<?php

namespace App\Controller\Api;

use App\Document\Message;
use App\Document\MessageGroupItem;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\MongoMessageService;
use App\Service\SocketService;
use App\Type\Message\GroupItem;
use App\Type\Message\Item;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/messages")
 */
class MessagesController extends AbstractFOSRestController
{
    /**
     * @Route("", name="messages")
     * @IsGranted("ROLE_USER")
     * @Rest\View(serializerGroups={"message","user"})
     * @param MongoMessageService $mongoMessageService
     * @param UserRepository $userRepository
     * @return View
     */
    public function index(
        MongoMessageService $mongoMessageService,
        UserRepository $userRepository
    )
    {
        /**@var User $sessionUser*/
        $sessionUser = $this->getUser();
        $result = new ArrayCollection($mongoMessageService->getGroups($sessionUser)->toArray());
        $otherUserIds = $result->map(function(MessageGroupItem $item) use ($sessionUser) {
            return $item->getTo() == $sessionUser->getId() ? $item->getFrom() : $item->getTo();
        });

        $otherUsers = new ArrayCollection($userRepository->findBy(['id' => $otherUserIds->toArray()]));
        $groupMapped = $result->map(function(MessageGroupItem $item) use($sessionUser, $otherUsers) {
            return GroupItem::map(
                $item,
                $sessionUser,
                $otherUsers->filter(function(User $other) use($item) {
                    return in_array($other->getId(), [$item->getTo(), $item->getFrom()]);
                })->current()
            );
        });

        return View::create($groupMapped);
    }

    /**
     * @Route("/{user}", name="messages_detail")
     * @IsGranted("ROLE_USER")
     * @Rest\View(serializerGroups={"message","user"})
     * @param MongoMessageService $mongoMessageService
     * @param User $user
     * @return View
     */
    public function detail(
        MongoMessageService $mongoMessageService,
        User $user
    )
    {
        /**@var User $sessionUser*/
        $sessionUser = $this->getUser();
        $result = $mongoMessageService->detail($sessionUser, $user);

        $itemsMapped = [];
        /**@var Message $item*/
        foreach ($result as $item) {
            $itemsMapped[] = Item::map(
                $item,
                $sessionUser,
                $user
            );
        }

        return View::create([
            'messages' =>$itemsMapped,
            'to' => $user
        ]);
    }

    /**
     * @Route("/add/{user}", name="messages_add", methods={"POST"})
     * @IsGranted("ROLE_USER")
     * @Rest\View(serializerGroups={"message","user"})
     * @param User $user
     * @param Request $request
     * @param SocketService $socketService
     * @param MongoMessageService $mongoMessageService
     * @return View
     */
    public function add(
        User $user,
        Request $request,
        SocketService $socketService,
        MongoMessageService $mongoMessageService
    )
    {
        /**@var User $sessionUser*/
        $sessionUser = $this->getUser();
        $text = $request->get('text');

        $message = $mongoMessageService->add($sessionUser, $user, $text);
        $item = Item::map($message, $sessionUser, $user);

        $socketService->sendMessage($user, $item);

        return  View::create($item);
    }

    /**
     * @Route("/read/{user}", name="messages_read", methods={"GET"})
     * @IsGranted("ROLE_USER")
     * @Rest\View(serializerGroups={"message","user"})
     * @param User $user
     * @param SocketService $socketService
     * @param MongoMessageService $mongoMessageService
     * @return View
     */
    public function read(
        User $user,
        SocketService $socketService,
        MongoMessageService $mongoMessageService
    )
    {
        /**@var User $sessionUser*/
        $sessionUser = $this->getUser();
        $result = $mongoMessageService->setRead($sessionUser, $user);

        $socketService->sendRead($user, $sessionUser);

        return View::create($result);
    }

}
