<?php

declare(strict_types=1);

namespace App\Stamp;

use Symfony\Component\Messenger\Stamp\StampInterface;

class LockStamp implements StampInterface
{
    public function __construct(
        public readonly int $lockKey
    ) {
    }
}
