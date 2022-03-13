<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Service\Response\MessageResponseService;
use App\Service\SocketService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/messages")
 */
class MessagesController extends AbstractFOSRestController
{
    /**
     * @Route("/{offset}", name="messages_index")
     * @Route("/group-list/{offset}", name="messages")
     * @IsGranted("ROLE_USER")
     * @Rest\View(serializerGroups={"message","user"})
     * @param MessageResponseService $messageResponseService
     * @param int $offset
     * @return View
     */
    public function groupList(
        MessageResponseService $messageResponseService,
        int $offset = 0
    ): View
    {
        /**@var User $sessionUser*/
        $sessionUser = $this->getUser();
        $response = $messageResponseService->groupList($sessionUser, $offset);

        return View::create($response);
    }

    /**
     * @Route("/detail/{user}/{offset}", name="messages_detail")
     * @IsGranted("ROLE_USER")
     * @Rest\View(serializerGroups={"message","user"})
     * @param MessageResponseService $messageResponseService
     * @param User $user
     * @param int $offset
     * @return View
     */
    public function detail(
        MessageResponseService $messageResponseService,
        User $user,
        int $offset = 0
    ): View
    {
        /**@var User $sessionUser*/
        $sessionUser = $this->getUser();
        $response = $messageResponseService->detail($sessionUser, $user, $offset);

        return View::create($response);
    }

    /**
     * @Route("/add/{user}", name="messages_add", methods={"POST"})
     * @IsGranted("ROLE_USER")
     * @Rest\View(serializerGroups={"message","user"})
     * @param User $user
     * @param Request $request
     * @param SocketService $socketService
     * @param MessageResponseService $messageResponseService
     * @return View
     */
    public function add(
        User $user,
        Request $request,
        SocketService $socketService,
        MessageResponseService $messageResponseService
    ): View
    {
        /**@var User $sessionUser*/
        $sessionUser = $this->getUser();
        $text = $request->get('text');

        $response = $messageResponseService->add($sessionUser, $user, $text);

        $socketService->sendMessage($user, $response);

        return  View::create($response);
    }

    /**
     * @Route("/read/{user}", name="messages_read", methods={"GET"})
     * @IsGranted("ROLE_USER")
     * @Rest\View(serializerGroups={"message","user"})
     * @param User $user
     * @param SocketService $socketService
     * @param MessageResponseService $messageResponseService
     * @return View
     */
    public function read(
        User $user,
        SocketService $socketService,
        MessageResponseService $messageResponseService
    ): View
    {
        /**@var User $sessionUser*/
        $sessionUser = $this->getUser();
        $result = $messageResponseService->read($sessionUser, $user);

        $socketService->sendRead($user, $sessionUser);

        return View::create($result);
    }

}
