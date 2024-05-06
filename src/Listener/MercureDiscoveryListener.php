<?php

declare(strict_types=1);

namespace App\Listener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\Mercure\Discovery;

#[AsEventListener(event: ResponseEvent::class)]
final readonly class MercureDiscoveryListener
{
    public function __construct(private Discovery $discovery)
    {
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        $request = $event->getRequest();

        $this->discovery->addLink($request);
    }
}
