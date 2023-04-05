<?php

declare(strict_types=1);

namespace App\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;
use Symfony\Component\Security\Http\Event\LogoutEvent;

class AuthenticationListener implements EventSubscriberInterface
{
    public function __construct(
        private HubInterface $hub
    ) {
    }

    public static function getSubscribedEvents() {
        return [
            LogoutEvent::class => 'onLogout',
            LoginSuccessEvent::class => 'onLogin'
        ];
    }

    public function onLogout(LogoutEvent $event)
    {
        $identifier = $event->getToken()->getUser()->getUserIdentifier();

        $update = new Update('https://dinosaur-app/activity', json_encode([
            'message' => "{$identifier} has logged out !"
        ]), true);

        $this->hub->publish($update);
    }

    public function onLogin(LoginSuccessEvent $event)
    {
        $identifier = $event->getAuthenticatedToken()->getUser()->getUserIdentifier();

        $update = new Update('https://dinosaur-app/activity', json_encode([
            'message' => "{$identifier} has logged in !"
        ]), true);

        $this->hub->publish($update);
    }
}
