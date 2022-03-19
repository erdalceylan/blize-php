<?php

namespace App\Listener;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class ResponseListener
{
    private ParameterBagInterface $parameterBag;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
    }

    public function onKernelResponse(ResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            // don't do anything if it's not the master request
            return;
        }

        $requestHeaders = $event->getRequest()->headers;
        $response = $event->getResponse();

        if($requestHeaders->has('webService')) {
            $response->headers->set("angular-hash", $this->parameterBag->get('angular_hash'));

        }else {
            $cookie = new Cookie(
                'socket-connection-url',
                $this->parameterBag->get('socket_connection_url'),
                new \DateTime('+ 1 day'),
                '/',
                null,
                false,
                false
            );

            $response->headers->setCookie($cookie);
        }
    }
}
