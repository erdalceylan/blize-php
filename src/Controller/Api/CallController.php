<?php

namespace App\Controller\Api;

use App\Controller\AbstractRestController;
use App\Entity\User;
use App\Service\MongoCallService;
use App\Service\SocketService;
use App\Type\Call\CallResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[Route(path: '/call')]
class CallController extends AbstractRestController
{


    #[Route(path: '/call/{user}', name: 'call_call', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function call(
        User $user,
        SocketService $socketService,
        MongoCallService $mongoCallService,
        Request $request
    ): JsonResponse
    {

        $this->getUser();
        /**@var User $sessionUser*/
        $sessionUser = $this->getUser();
        $call = $mongoCallService->call($sessionUser, $user, !!$request->get("video"));
        $item = CallResponse::fill($call, $sessionUser, $user);

        $socketService->sendCall($user, $item);
        return $this->json($item, context: ['groups' => ["call","user"]]);

    }

    #[Route(path: '/accept/{user}/{id}', name: 'call_answer', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function accept(
        User $user,
        string $id,
        SocketService $socketService,
        MongoCallService $mongoCallService
    ): JsonResponse {
        /** @var User $sessionUser */
        $sessionUser = $this->getUser();

        $result = $mongoCallService->accept($sessionUser, $id);
        $item = CallResponse::fill($result, $sessionUser, $user);

        $socketService->sendAnswer($user, $item);

        return $this->json($item, context: ['groups' => ["call", "user"]]);
    }

    #[Route(path: '/close/{user}/{id}', name: 'call_close', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function close(
        User $user,
        string $id,
        SocketService $socketService,
        MongoCallService $mongoCallService
    ): JsonResponse {
        /** @var User $sessionUser */
        $sessionUser = $this->getUser();

        $result = $mongoCallService->close($sessionUser, $user, $id);
        $item = CallResponse::fill($result, $sessionUser, $user);

        $socketService->sendCallEnd($user, $item);

        return $this->json($item, context: ['groups' => ["call", "user"]]);
    }

}
