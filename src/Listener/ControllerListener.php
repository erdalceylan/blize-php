<?php


namespace App\Listener;

use App\Entity\User;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;

class ControllerListener
{
    /**
     * @var Environment
     */
    private $twig;
    /**
     * @var Security
     */
    private $security;

    public function __construct(
        Environment $twig,
        Security $security
    )
    {
        $this->twig = $twig;
        $this->security = $security;
    }

    public function onKernelController(ControllerEvent $event)
    {
        if (!$event->isMasterRequest() || $event->getRequest()->get('_route') === '_wdt') {
            // don't do anything if it's not the master request
            return;
        }
        if (!$this->security->getUser() instanceof User) {
            return;
        }
        //webservice check (angular)
        if(!$event->getRequest()->headers->has('webService')) {

            $controller = $event->getController();

            // variable check
            if (is_array($controller) && count($controller)) {

                // controller check
                if ($controller[0] instanceof AbstractFOSRestController) {

                    //if api controller direct call redirect to dashboard
                    $event->setController(function () {
                        return new Response(
                            $this->twig->render('dashboard/index.html.twig'),
                            200,
                            ['Content-Type' => 'text/html; charset=utf-8']
                        );
                    });
                }
            }
        }
    }
}
