<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Service\MongoStoryService;
use App\Service\Response\StoryResponseService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/story")
 */
class StoryController extends AbstractFOSRestController
{

    /**
     * @Route("/group-list/{offset}", name="story_list", methods={"GET"})
     * @IsGranted("ROLE_USER")
     * @Rest\View(serializerGroups={"story","user"})
     * @param StoryResponseService $storyResponseService
     * @param int $offset
     * @return View
     */
    public function groupList(
        StoryResponseService $storyResponseService,
        int $offset = 0
    ): View
    {
        /**@var User $sessionUser*/
        $sessionUser = $this->getUser();
        $response = $storyResponseService->groupList($sessionUser, $offset);

        return  View::create($response);
    }

    /**
     * @Route("/me-list", name="story_me", methods={"GET"})
     * @IsGranted("ROLE_USER")
     * @Rest\View(serializerGroups={"story","user"})
     * @param StoryResponseService $storyResponseService
     * @return View
     */
    public function meList(
        StoryResponseService $storyResponseService
    ): View
    {
        /**@var User $sessionUser*/
        $sessionUser = $this->getUser();
        $response = $storyResponseService->meList($sessionUser);

        return  View::create($response);
    }

    /**
     * @Route("/view-list/{_id}/{offset}", name="story_views", methods={"GET"})
     * @IsGranted("ROLE_USER")
     * @Rest\View(serializerGroups={"story","user"})
     * @param StoryResponseService $storyResponseService
     * @param string $_id
     * @param int $offset
     * @return View
     */
    public function viewList(
        StoryResponseService $storyResponseService,
        string $_id,
        int $offset
    ): View
    {
        /**@var User $sessionUser*/
        $sessionUser = $this->getUser();
        $response = $storyResponseService->viewList($sessionUser, $_id, $offset);

        return  View::create($response);
    }

    /**
     * @Route("/add", name="story_add", methods={"POST"})
     * @IsGranted("ROLE_USER")
     * @Rest\View(serializerGroups={"story","user"})
     * @Rest\FileParam(name="image", image=true)
     * @param ParamFetcherInterface $paramFetcher
     * @param StoryResponseService $storyResponseService
     * @return View
     */
    public function add(
        ParamFetcherInterface $paramFetcher,
        StoryResponseService $storyResponseService
    ): View
    {
        /**@var $image UploadedFile*/
        $image = $paramFetcher->get("image");
        /**@var User $sessionUser*/
        $sessionUser = $this->getUser();
        $response = $storyResponseService->add($sessionUser, $image);

        return  View::create($response);
    }

    /**
     * @Route("/seen/{_id}", name="story_seen", methods={"GET"})
     * @IsGranted("ROLE_USER")
     * @param StoryResponseService $storyResponseService
     * @param string $_id
     * @return View
     */
    public function seen(
        StoryResponseService $storyResponseService,
        string $_id
    ): View
    {
        /**@var User $sessionUser*/
        $sessionUser = $this->getUser();
        $response = $storyResponseService->seen($sessionUser, $_id);

        return  View::create($response);
    }

    /**
     * @Route("/delete/{_id}", name="story_delete", methods={"GET"})
     * @IsGranted("ROLE_USER")
     * @return View
     */
    public function delete(
        MongoStoryService $mongoStoryService,
        string $_id
    )
    {
        /**@var User $sessionUser*/
        $sessionUser = $this->getUser();

        $result = $mongoStoryService->delete($sessionUser, $_id);

        return  View::create($result);
    }

}
