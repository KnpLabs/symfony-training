<?php

declare(strict_types=1);

namespace Domain\Collection;

use Domain\Model\User;

interface UsersCollection
{
    public function add(User $user): void;
}
