<?php

namespace App\Service\Response;

use App\Document\Result\StoryGroup;
use App\Document\Result\StoryMeItem;
use App\Document\Result\StoryViewItem;
use App\Document\Story;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\MongoStoryService;
use App\Type\Story\StoryGroupResponse;
use App\Type\Story\StoryMeItemResponse;
use App\Type\Story\StoryResponse;
use App\Type\Story\StoryViewItemResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class StoryResponseService
{
    private MongoStoryService $mongoStoryService;
    private UserRepository $userRepository;

    public function __construct(
        MongoStoryService $mongoStoryService,
        UserRepository $userRepository
    )
    {
        $this->mongoStoryService = $mongoStoryService;
        $this->userRepository = $userRepository;
    }

    /**
     * @param User $sessionUser
     * @param int $offset
     * @return StoryGroupResponse[]
     */
    public function groupList(User $sessionUser, int $offset = 0): array
    {
        $list = $this->mongoStoryService->groupList($sessionUser, $offset)->toArray();

        $userIds = array_map(function(StoryGroup $item) {
            return $item->getFrom();
        }, $list);

        $users = $this->userRepository->findBy(['id' => $userIds]);

        return  array_map(function(StoryGroup $storyGroup) use($users) {

            $filteredUser = array_filter($users, function ($user) use ($storyGroup) {
                return $storyGroup->getFrom() == $user->getId();
            });

            return StoryGroupResponse::fill($storyGroup, current($filteredUser));
        }, $list);
    }

    /**
     * @param User $sessionUser
     * @return StoryMeItemResponse[]
     */
    public function meList(User $sessionUser): array
    {
        $list = $this->mongoStoryService->meList($sessionUser)->toArray();

        $userIds = [];

        array_map(function(StoryMeItem $item) use (&$userIds) {
            foreach ($item->getViews() as $view) {
                $userIds[] = $view->getFrom();
            }
        }, $list);

        $users = $this->userRepository->findBy(['id' => $userIds]);

        return  array_map(function(StoryMeItem $storyMeItem) use($sessionUser, $users) {

            $storyMeItemResponse = StoryMeItemResponse::fill($sessionUser, $storyMeItem);

            foreach ($storyMeItem->getViews() as $view) {

                $filteredUser = array_filter($users,function (User $user) use($view) {
                    return $user->getId() == $view->getFrom();
                });

                $storyMeItemResponse->addView(StoryViewItemResponse::fill($view, current($filteredUser)));
            }

            return $storyMeItemResponse;
        }, $list);
    }

    /**
     * @param User $sessionUser
     * @param string $_id
     * @param int $offset
     * @return StoryViewItemResponse[]
     */
    public function viewList(User $sessionUser, string $_id, int $offset = 0): array
    {
        $userIds = [];
        $views = $this->mongoStoryService->viewList($sessionUser, $_id, $offset);

        foreach ($views as $view) {
            $userIds[] = $view->getFrom();
        }

        $users = $this->userRepository->findBy(['id' => $userIds]);

        return array_map(function (StoryViewItem $storyViewItem) use($users) {
            $filteredUsers = array_filter($users, function ($user) use ($storyViewItem) {
                return $user->getId() === $storyViewItem->getFrom();
            });

            return StoryViewItemResponse::fill($storyViewItem, current($filteredUsers));
        }, $views);
    }

    /**
     * @param User $sessionUser
     * @param UploadedFile $uploadedFile
     * @return StoryResponse|null
     */
    public function add(User $sessionUser, UploadedFile $uploadedFile): ?StoryResponse
    {
        $story = $this->mongoStoryService->add($sessionUser, $uploadedFile->getRealPath());
        if ($story instanceof Story) {
            return StoryResponse::fill($story, $sessionUser);
        }

        return null;
    }

    /**
     * @param User $sessionUser
     * @param $_id
     * @return mixed
     */
    public function seen(User $sessionUser, $_id)
    {
        return $this->mongoStoryService->seen($sessionUser, $_id);
    }

    /**
     * @param User $sessionUser
     * @param $_id
     * @return mixed
     */
    public function delete(User $sessionUser, $_id)
    {
        return $this->mongoStoryService->delete($sessionUser, $_id);
    }
}
