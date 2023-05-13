<?php

declare(strict_types=1);

namespace App\Listener;

use App\JwtFactory;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\Security\Core\Security;

#[AsEventListener(event: ResponseEvent::class)]
class MercureAuthorizationListener
{
    public function __construct(
        private Security $security,
        private JwtFactory $jwtFactory
    ) {
    }

    public function onKernelResponse(ResponseEvent $event)
    {
        $isAdmin = $this->security->isGranted('ROLE_ADMIN');

        if (!$isAdmin) {
            return;
        }

        $token = $this->jwtFactory->generateJwt($event->getRequest());

        $response = $event->getResponse();

        /*
         * Allow admin users to subscribe to private topics using jwt token.
         */
        $response->headers->set('x-mercure-token', "Bearer {$token}");
    }
}
