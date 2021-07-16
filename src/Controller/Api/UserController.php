<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Repository\UserRepository;
use Firebase\JWT\JWT;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends AbstractFOSRestController
{

    /**
     * @Route("/list", name="user_ping")
     * @IsGranted("ROLE_USER")
     * @Rest\View(serializerGroups={"user"})
     * @param UserRepository $userRepository
     * @return View
     */
    public function list(UserRepository $userRepository)
    {
        /**@var User $user*/
        $user = $this->getUser();
        $user = $userRepository->updateLasSeen($user);

        return View::create($user);
    }

    /**
     * @Route("/ping", name="user_ping")
     * @IsGranted("ROLE_USER")
     * @Rest\View(serializerGroups={"user"})
     * @param UserRepository $userRepository
     * @return View
     */
    public function ping(UserRepository $userRepository)
    {
        /**@var User $user*/
        $user = $this->getUser();
        $user = $userRepository->updateLasSeen($user);

        return View::create($user);
    }

    /**
     * @Route("/detail/{user}", name="user_detail")
     * @IsGranted("ROLE_USER")
     * @Rest\View(serializerGroups={"user"})
     * @param User $user
     * @return View
     */
    public function detail(User $user)
    {
        return View::create($user);
    }

    /**
     * @Route("/detail-username/{userName}", name="user_detail_username")
     * @IsGranted("ROLE_USER")
     * @Rest\View(serializerGroups={"user"})
     * @param UserRepository $userRepository
     * @param $userName
     * @return View
     */
    public function detailByUsername(
        UserRepository $userRepository,
        $userName
    )
    {
        $user = $userRepository->findOneBy(['username' => $userName]);
        return View::create($user);
    }

    /**
     * @Route("/jwt", name="user_jwt")
     * @IsGranted("ROLE_USER")
     * @return View
     */
    public function jwt()
    {
        /**@var User $user*/
        $user = $this->getUser();

        $privateKey = file_get_contents($this->getParameter('rsa_private'));
        //$publicKey = file_get_contents($this->getParameter('rsa_public'));
        //$encoded = JWT::encode(['name' => 'erdal'], $privateKey, 'RS256');
        //$decoded = JWT::decode($encoded, $publicKey, ['RS256']);


        $payload = [
            'exp' => (new \DateTime())->modify('+ 30 second')->getTimestamp(),
            'user' => json_decode($this->json($user, 200, [], ['groups' => ['user']])->getContent())
        ];

        $token = JWT::encode($payload, $privateKey, 'RS256');

        return View::create(['token' => $token]);
    }
}
