<?php

namespace App\Controller\Api;

use App\Controller\AbstractRestController;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: '/search')]
class SearchController extends AbstractRestController
{
    #[Route(path: '/list/{offset}', name: 'search_list', requirements: ['offset' => '\d+'])]
    #[Route(path: '/{offset}', name: 'search', requirements: ['offset' => '\d+'])]
    #[IsGranted('ROLE_USER')]
    public function index(
        UserRepository $userRepository,
        int $offset = 0
    ): JsonResponse {
        /** @var User $user */
        $currentUser = $this->getUser();
        $users = $userRepository->findAllExclude([$currentUser->getId()], $offset);

        return $this->json($users, context: ['groups' => ["user"]]);
    }

}