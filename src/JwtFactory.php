<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mercure\Authorization;

class JwtFactory
{
    public function __construct(
        private Authorization $authorization
    ) {
    }

    public function generateJwt(Request $request): string
    {
        /*
         * Using mercure authorization service to generate jwt token allows you to create
         * the token using the existing mercure configuration.
         */
        return $this->authorization->createCookie($request, ["*"])->getValue();
    }
}
