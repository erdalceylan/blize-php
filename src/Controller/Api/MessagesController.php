<?php

namespace App\Controller\Api;

use App\Controller\AbstractRestController;
use App\Entity\User;
use App\Service\Response\MessageResponseService;
use App\Service\SocketService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: '/messages')]
class MessagesController extends AbstractRestController
{
    #[Route(path: '/{offset}', name: 'messages_index')]
    #[Route(path: '/group-list/{offset}', name: 'messages')]
    #[IsGranted('ROLE_USER')]
    public function groupList(
        MessageResponseService $messageResponseService,
        int $offset = 0
    ): JsonResponse {
        /** @var User $sessionUser */
        $sessionUser = $this->getUser();
        $response = $messageResponseService->groupList($sessionUser, $offset);

        return $this->json($response, context: ['groups' => ["message", "user"]]);
    }

    #[Route(path: '/detail/{user}/{offset}', name: 'messages_detail')]
    #[IsGranted('ROLE_USER')]
    public function detail(
        MessageResponseService $messageResponseService,
        User $user,
        int $offset = 0
    ): JsonResponse {
        /** @var User $sessionUser */
        $sessionUser = $this->getUser();
        $response = $messageResponseService->detail($sessionUser, $user, $offset);

        return $this->json($response, context: ['groups' => ["message", "user"]]);
    }

    #[Route(path: '/add/{user}', name: 'messages_add', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function add(
        User $user,
        Request $request,
        SocketService $socketService,
        MessageResponseService $messageResponseService
    ): JsonResponse {
        /** @var User $sessionUser */
        $sessionUser = $this->getUser();
        $text = $request->get('text');

        $response = $messageResponseService->add($sessionUser, $user, $text);

        $socketService->sendMessage($user, $response);

        return $this->json($response, context: ['groups' => ["message", "user"]]);
    }

    #[Route(path: '/read/{user}', name: 'messages_read', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function read(
        User $user,
        SocketService $socketService,
        MessageResponseService $messageResponseService
    ): JsonResponse {
        /** @var User $sessionUser */
        $sessionUser = $this->getUser();
        $result = $messageResponseService->read($sessionUser, $user);

        $socketService->sendRead($user, $sessionUser);

        return $this->json($result, context: ['groups' => ["message", "user"]]);
    }
}