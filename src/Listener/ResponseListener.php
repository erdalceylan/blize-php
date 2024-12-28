<?php

namespace App\Listener;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class ResponseListener
{
    public function __construct(
        private readonly ParameterBagInterface $parameterBag
    ){}

    public function onKernelResponse(ResponseEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $requestHeaders = $event->getRequest()->headers;
        $response = $event->getResponse();

        if ($requestHeaders->has('webService')) {
            $response->headers->set("angular-hash", $this->parameterBag->get('angular_hash'));
        }

        if (!$event->getRequest()->cookies->has("socket-connection-url")) {
            $cookie = Cookie::create( // Cookie::create() kullanımı
                'socket-connection-url',
                $this->parameterBag->get('socket_connection_url'),
                new \DateTimeImmutable('+1 day'),
                path: '/',
                secure: false,
                httpOnly: false
            );

            $response->headers->setCookie($cookie);
        }
    }
}