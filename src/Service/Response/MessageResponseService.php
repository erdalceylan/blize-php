<?php

namespace App\Service\Response;

use App\Document\Message;
use App\Document\Result\MessageGroupItem;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\MongoMessageService;
use App\Type\Message\MessageDetailResponse;
use App\Type\Message\MessageGroupItemResponse;
use App\Type\Message\MessageResponse;

class MessageResponseService
{
    private MongoMessageService $mongoMessageService;
    private UserRepository $userRepository;

    public function __construct(
        MongoMessageService $mongoMessageService,
        UserRepository $userRepository
    )
    {
        $this->mongoMessageService = $mongoMessageService;
        $this->userRepository = $userRepository;
    }

    /**
     * @param User $sessionUser
     * @param int $offset
     * @return MessageGroupItemResponse[]
     */
    public function groupList(User $sessionUser, int $offset = 0): array
    {
        $list = $this->mongoMessageService->groupList($sessionUser, $offset)->toArray();

        $otherUserIds = array_map(function(MessageGroupItem $item) use ($sessionUser) {
            return $item->getTo() == $sessionUser->getId() ? $item->getFrom() : $item->getTo();
        }, $list);

        $otherUsers = $this->userRepository->findBy(['id' => $otherUserIds]);

        return array_map(function(MessageGroupItem $messageGroupItem) use($sessionUser, $otherUsers) {

            $filteredOtherUserForGroupItem = array_filter($otherUsers, function(User $other) use($messageGroupItem) {
                return in_array($other->getId(), [$messageGroupItem->getTo(), $messageGroupItem->getFrom()]);
            });

            return MessageGroupItemResponse::fill(
                $messageGroupItem,
                $sessionUser,
                current($filteredOtherUserForGroupItem)
            );
        }, $list);
    }

    public function detail(User $sessionUser, User $otherUser, int $offset = 0)
    {
        $list = $this->mongoMessageService->detail($sessionUser, $otherUser, $offset);
        $messageResponseItems= [];
        /**@var Message $item*/
        foreach ($list as $message) {
            $messageResponseItems[] = MessageResponse::fill(
                $message,
                $sessionUser,
                $otherUser
            );
        }

        return MessageDetailResponse::fill($otherUser, $messageResponseItems);
    }

    public function add(User $sessionUser, User $otherUser, ?string $text)
    {
        $message = $this->mongoMessageService->add($sessionUser, $otherUser, $text);
        return MessageResponse::fill($message, $sessionUser, $otherUser);
    }

    public function read(User $sessionUser, User $otherUser)
    {
        return $this->mongoMessageService->read($sessionUser, $otherUser);
    }
}
