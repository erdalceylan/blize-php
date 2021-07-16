<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Repository\UserRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/search")
 */
class SearchController extends AbstractFOSRestController
{

    /**
     * @Route("", name="search")
     * @IsGranted("ROLE_USER")
     * @Rest\View(serializerGroups={"user"})
     * @param UserRepository $userRepository
     * @return View
     */
    public function index(UserRepository $userRepository)
    {
        /**@var User $user*/
        $user = $this->getUser();
        $user = $userRepository->findAllExclude([$user->getId()]);

        return View::create($user);
    }

}
