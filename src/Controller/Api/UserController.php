<?php

namespace App\Controller\Api;

use App\Controller\AbstractRestController;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\UserService;
use Firebase\JWT\JWT;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: '/user')]
class UserController extends AbstractRestController
{
    #[Route(path: '/ping', name: 'user_ping', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function ping(UserService $userService): JsonResponse
    {
        $user = $this->getUser();
        $userService->updateLasSeen($user);

        return $this->json($user, context: ['groups' => ["user"]]);
    }

    #[Route(path: '/detail/{user}', name: 'user_detail', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function detail(User $user): JsonResponse
    {
        return $this->json($user, context: ['groups' => ["user"]]);
    }

    #[Route(path: '/detail-username/{userName}', name: 'user_detail_username', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function detailByUsername(
        UserRepository $userRepository,
        string $userName
    ): JsonResponse {
        $user = $userRepository->findOneBy(['username' => $userName]);

        return $this->json($user, context: ['groups' => ["user"]]);
    }

    #[Route(path: '/jwt', name: 'user_jwt', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function jwt(): JsonResponse
    {
        $user = $this->getUser();

        $privateKey = file_get_contents($this->getParameter('rsa_private'));

        $payload = [
            'exp' => (new \DateTimeImmutable())->modify('+ 30 second')->getTimestamp(),
            'user' => json_decode($this->json($user, context: ['groups' => ['user']])->getContent(), true)
        ];

        $token = JWT::encode($payload, $privateKey, 'RS256');

        return $this->json(['token' => $token]);
    }

}