<?php

namespace App\Controller\Api;

use App\Controller\AbstractRestController;
use App\Service\MongoStoryService;
use App\Service\Response\StoryResponseService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpFoundation\Request;

#[Route(path: '/story')]
class StoryController extends AbstractRestController
{
    #[Route(path: '/group-list/{offset}', name: 'story_list', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function groupList(
        StoryResponseService $storyResponseService,
        int $offset = 0
    ): JsonResponse {
        $sessionUser = $this->getUser();
        $response = $storyResponseService->groupList($sessionUser, $offset);

        return $this->json($response, context: ['groups' => ["story", "user"]]);
    }

    #[Route(path: '/me-list', name: 'story_me', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function meList(
        StoryResponseService $storyResponseService
    ): JsonResponse {
        $sessionUser = $this->getUser();
        $response = $storyResponseService->meList($sessionUser);

        return $this->json($response, context: ['groups' => ["story", "user"]]);
    }

    #[Route(path: '/view-list/{_id}/{offset}', name: 'story_views', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function viewList(
        StoryResponseService $storyResponseService,
        string $_id,
        int $offset
    ): JsonResponse {
        $sessionUser = $this->getUser();
        $response = $storyResponseService->viewList($sessionUser, $_id, $offset);

        return $this->json($response, context: ['groups' => ["story", "user"]]);
    }

    #[Route(path: '/add', name: 'story_add', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function add(
        Request $request,
        StoryResponseService $storyResponseService
    ): JsonResponse {
        $image = $request->files->get('image');
        $sessionUser = $this->getUser();
        $response = $storyResponseService->add($sessionUser, $image);

        return $this->json($response, context: ['groups' => ["story", "user"]]);
    }

    #[Route(path: '/seen/{_id}', name: 'story_seen', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function seen(
        StoryResponseService $storyResponseService,
        string $_id
    ): JsonResponse {
        $sessionUser = $this->getUser();
        $response = $storyResponseService->seen($sessionUser, $_id);

        return $this->json($response, context: ['groups' => ["story", "user"]]);
    }

    #[Route(path: '/delete/{_id}', name: 'story_delete', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function delete(
        MongoStoryService $mongoStoryService,
        string $_id
    ): JsonResponse {
        $sessionUser = $this->getUser();

        $result = $mongoStoryService->delete($sessionUser, $_id);

        return $this->json($result, context: ['groups' => ["story", "user"]]);
    }

}