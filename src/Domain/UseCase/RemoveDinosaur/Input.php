<?php

declare(strict_types=1);

namespace Domain\UseCase\RemoveDinosaur;

final class Input
{
    public function __construct(
        public readonly string $id
    ) {
    }
}
