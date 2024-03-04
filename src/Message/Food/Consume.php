<?php

declare(strict_types=1);

namespace App\Message\Food;

use App\Message\Lockable;

class Consume implements Lockable
{
    public function __construct(
        public readonly int $dinosaurId,
        public readonly string $dinosaurName
    ) {
    }
}
