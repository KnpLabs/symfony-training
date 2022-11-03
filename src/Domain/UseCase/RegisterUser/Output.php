<?php

declare(strict_types=1);

namespace Domain\UseCase\RegisterUser;

use Domain\Model\User;

final class Output
{
    public function __construct(
        public readonly User $user
    ) {
    }
}
