<?php

declare(strict_types=1);

namespace Domain\UseCase\RegisterUser;

final class Input
{
    public function __construct(
        public readonly string $email,
        public readonly string $password
    ) {
    }
}
