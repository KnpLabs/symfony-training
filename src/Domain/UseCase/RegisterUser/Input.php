<?php

declare(strict_types=1);

namespace Domain\UseCase\RegisterUser;

final readonly class Input
{
    public function __construct(
        public string $email,
        public string $password
    ) {
    }
}
