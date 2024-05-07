<?php

declare(strict_types=1);

namespace App\Listener;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\Mercure\Authorization;

#[AsEventListener(event: ResponseEvent::class)]
final readonly class MercureAuthorizationListener
{
    public function __construct(
        private Security $security,
        private Authorization $authorization
    ) {
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        $topics = [];

        if ($this->security->isGranted('ROLE_USER')) {
            $topics[] = 'http://localhost/dinosaurs';
        }

        if ($this->security->isGranted('ROLE_ADMIN')) {
            $topics[] = 'http://localhost/activity';
        }

        if (empty($topics)) {
            return;
        }

        $request = $event->getRequest();

        $this->authorization->setCookie($request, $topics);
    }
}
