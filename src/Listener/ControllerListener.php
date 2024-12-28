<?php

namespace App\Listener;

use App\Controller\AbstractRestController;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use \Symfony\Bundle\SecurityBundle\Security ;
use Twig\Environment;

class ControllerListener
{

    public function __construct(
        private readonly Environment $twig,
        private readonly Security $security
    ) {}

    public function onKernelController(ControllerEvent $event): void
    {
        if (!$event->isMainRequest()|| $event->getRequest()->get('_route') === '_wdt') {
            return;
        }

        if (!$this->security->getUser() instanceof User) {
            return;
        }

        if (!$event->getRequest()->headers->has('webService')) {
            $controller = $event->getController();

            if (is_array($controller) && count($controller) > 0) {

                if ($controller[0] instanceof AbstractRestController) {
                    $event->setController(function () {
                        return new Response(
                            $this->twig->render('dashboard/index.html.twig'),
                            Response::HTTP_OK,
                            ['Content-Type' => 'text/html; charset=utf-8']
                        );
                    });
                }
            }
        }
    }
}