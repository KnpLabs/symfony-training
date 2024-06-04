<?php

declare(strict_types=1);

namespace App\Listener;

use App\Realtime\Trigger\UserLoggetIn;
use App\Realtime\Trigger\UserLoggetOut;
use App\Service\Realtime\Publisher;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;
use Symfony\Component\Security\Http\Event\LogoutEvent;

final readonly class AuthenticationListener
{
    public function __construct(
        private Publisher $publisher
    ) {
    }

    #[AsEventListener(event: LoginSuccessEvent::class)]
    public function onLoginSuccess(LoginSuccessEvent $event): void
    {
        $identifier = $event->getAuthenticatedToken()->getUserIdentifier();

        $this->publisher->publish(new UserLoggetIn($identifier));
    }

    #[AsEventListener(event: LogoutEvent::class)]
    public function onLogout(LogoutEvent $event): void
    {
        $identifier = $event->getToken()->getUserIdentifier();

        $this->publisher->publish(new UserLoggetOut($identifier));
    }
}
