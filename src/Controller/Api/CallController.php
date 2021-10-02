<?php

namespace App\Controller\Api;

use App\Document\Call;
use App\Entity\User;
use App\Service\MongoCallService;
use App\Service\SocketService;
use App\Type\Call\Item;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/call")
 */
class CallController extends AbstractFOSRestController
{

    /**
     * @Route("/call/{user}", name="call_call", methods={"POST"})
     * @IsGranted("ROLE_USER")
     * @Rest\View(serializerGroups={"call","user"})
     * @param User $user
     * @param SocketService $socketService
     * @param MongoCallService $mongoCallService
     * @return View
     */
    public function call(
        User $user,
        SocketService $socketService,
        MongoCallService $mongoCallService,
        Request $request
    )
    {

        $this->getUser();
        /**@var User $sessionUser*/
        $sessionUser = $this->getUser();
        $call = $mongoCallService->call($sessionUser, $user, !!$request->get("video"));
        $item = Item::map($call, $sessionUser, $user);

        $socketService->sendCall($user, $item);

        return  View::create($item);
    }

    /**
     * @Route("/accept/{user}/{id}", name="call_answer", methods={"GET"})
     * @IsGranted("ROLE_USER")
     * @Rest\View(serializerGroups={"call","user"})
     * @param string $id
     * @param User $user
     * @param SocketService $socketService
     * @param MongoCallService $mongoCallService
     * @return View
     */
    public function accept(
        User $user,
        string $id,
        SocketService $socketService,
        MongoCallService $mongoCallService
    )
    {
        /**@var User $sessionUser*/
        $sessionUser = $this->getUser();

        /**@var Call $result*/
        $result = $mongoCallService->accept($sessionUser, $id);
        $item = Item::map($result, $sessionUser, $user);

        $socketService->sendAnswer($user, $item);

        return View::create($item);
    }

    /**
     * @Route("/close/{user}/{id}", name="call_close", methods={"GET"})
     * @IsGranted("ROLE_USER")
     * @Rest\View(serializerGroups={"call","user"})
     * @param string $id
     * @param User $user
     * @param SocketService $socketService
     * @param MongoCallService $mongoCallService
     * @return View
     */
    public function close(
        User $user,
        string $id,
        SocketService $socketService,
        MongoCallService $mongoCallService
    )
    {
        /**@var User $sessionUser*/
        $sessionUser = $this->getUser();

        /**@var Call $result*/
        $result = $mongoCallService->close($sessionUser, $user, $id);
        $item = Item::map($result, $sessionUser, $user);

        $socketService->sendCallEnd($user, $item);

        return View::create($item);
    }

}
