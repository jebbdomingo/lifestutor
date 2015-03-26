<?php

namespace Lifestutor\StoreBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class CorsResponseListener
{
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $response = $event->getResponse();

        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Credentials', true);
        $response->headers->set('Access-Control-Max-Age', 86400);

        $event->setResponse($response);
    }
}