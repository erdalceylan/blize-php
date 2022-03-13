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
     * @Route("/list/{offset}", name="search_list")
     * @Route("/{offset}", name="search")
     * @IsGranted("ROLE_USER")
     * @Rest\View(serializerGroups={"user"})
     * @param UserRepository $userRepository
     * @param int $offset
     * @return View
     */
    public function index(
        UserRepository $userRepository,
        int $offset = 0
    )
    {
        /**@var User $user*/
        $user = $this->getUser();
        $user = $userRepository->findAllExclude([$user->getId()], $offset);

        return View::create($user);
    }

}
