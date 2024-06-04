<?php

declare(strict_types=1);

namespace App\Listener;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\Mercure\HubInterface;

#[AsEventListener(event: ResponseEvent::class)]
final readonly class MercureAuthorizationListener
{
    public function __construct(
        private Security $security,
        private HubInterface $hubInterface
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

        $response = $event->getResponse();

        // Generate the JWT token
        $JWTfactory = $this->hubInterface->getFactory();

        if (null === $JWTfactory) {
            throw new \RuntimeException('The hub factory is not available.');
        }

        $token = $JWTfactory->create($topics);

        $response->headers->set('X-Mercure-JWT', $token);
    }
}
