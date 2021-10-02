<?php

namespace App\Listener;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
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

        $event
            ->getResponse()
            ->headers
            ->set("angular-hash", $this->parameterBag->get('angular_hash'));
    }
}
