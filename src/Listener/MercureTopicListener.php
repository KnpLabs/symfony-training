<?php

declare(strict_types=1);

namespace App\Listener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\Mercure\Discovery;

#[AsEventListener(event: ResponseEvent::class)]
class MercureTopicListener
{
    public function __construct(
        private Discovery $discovery
    ) {
    }

    public function onKernelResponse(ResponseEvent $event)
    {
        $request = $event->getRequest();
        $response = $event->getResponse();

        /**
         * Here we could eventually read a config file to
         * determine which routes should correspond to which topics.
         */
        $path = $request->getPathInfo();

        $this->discovery->addLink($request);

        $response->headers->set('x-mercure-topic', sprintf(
            'https://dinosaur-app%s',
            $path
        ));
    }
}
