<?php

declare(strict_types=1);

namespace Domain\UseCase\CreateDinosaur;

use Domain\Model\Dinosaur;

final class Output
{
    public function __construct(
        public readonly Dinosaur $dinosaur
    ) {
    }
}
