<?php

declare(strict_types=1);

namespace Domain\UseCase\CreateDinosaur;

use Domain\Model\Dinosaur;

final readonly class Output
{
    public function __construct(
        public Dinosaur $dinosaur
    ) {
    }
}
