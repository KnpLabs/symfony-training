<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mercure\Authorization;
use Symfony\Component\Security\Core\Security;

class JwtFactory
{
    public function __construct(
        private Authorization $authorization,
        private Security $security
    ) {
    }

    public function generateJwt(Request $request): string
    {
        $isAdmin = $this->security->isGranted('ROLE_ADMIN');

        $subscriptions = $isAdmin
            ? $this->getAdminSubscriptions()
            : $this->getUserSubscriptions()
        ;

        /*
         * Using mercure authorization service to generate jwt token allows you to create
         * the token using the existing mercure configuration.
         */
        return $this->authorization->createCookie($request, $subscriptions)->getValue();
    }

    private function getAdminSubscriptions()
    {
        return [
            'https://dinosaur-app/dinosaurs/{id}',
            'https://dinosaur-app/activity'
        ];
    }

    private function getUserSubscriptions()
    {
        return [
            'https://dinosaur-app/dinosaurs/{id}'
        ];
    }
}
