<?php

namespace App\Controller\Api;

use App\Document\StoryGroupItem;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\MongoStoryService;
use App\Type\Story\GroupItem;
use App\Type\Story\Item;
use Doctrine\Common\Collections\ArrayCollection;
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
     * @Route("/list/{offset}", name="story_list", methods={"GET"})
     * @IsGranted("ROLE_USER")
     * @Rest\View(serializerGroups={"story","user"})
     * @param UserRepository $userRepository
     * @return View
     */
    public function list(
        UserRepository $userRepository,
        MongoStoryService $mongoStoryService,
        $offset = 0
    )
    {


        /**@var User $sessionUser*/
        $sessionUser = $this->getUser();
        $result = new ArrayCollection($mongoStoryService->getGroups($sessionUser, $offset)->toArray());

        $userIds = $result->map(function(StoryGroupItem $item) {
            return $item->getFrom();
        });

        $users = new ArrayCollection($userRepository->findBy(['id' => $userIds->toArray()]));

        $groupMapped = $result->map(function(StoryGroupItem $groupItem) use($users) {
            return GroupItem::map(
                $groupItem,
                $users->filter(function (User $user) use($groupItem) {
                    return $user->getId() == $groupItem->getFrom();
                })->current()
            );
        });

        return  View::create($groupMapped);
    }

    /**
     * @Route("/add", name="story_add", methods={"POST"})
     * @IsGranted("ROLE_USER")
     * @Rest\View(serializerGroups={"story","user"})
     * @Rest\FileParam(name="image", image=true)
     * @return View
     */
    public function add(
        ParamFetcherInterface $paramFetcher,
        MongoStoryService $mongoStoryService
    )
    {

        /**@var $image UploadedFile*/
        $image = $paramFetcher->get("image");
        /**@var User $sessionUser*/
        $sessionUser = $this->getUser();

        $story = $mongoStoryService->add($sessionUser, $image->getRealPath());

        return  View::create(Item::map($story, $sessionUser));
    }

    /**
     * @Route("/seen/{_id}", name="story_seen", methods={"GET"})
     * @IsGranted("ROLE_USER")
     * @return View
     */
    public function seen(
        MongoStoryService $mongoStoryService,
        string $_id
    )
    {

        /**@var User $sessionUser*/
        $sessionUser = $this->getUser();

        $result = $mongoStoryService->seen($sessionUser, $_id);

        return  View::create($result);
    }


}
