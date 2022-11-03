<?php

declare(strict_types=1);

namespace Domain\UseCase\EditSpecies;

use Domain\Model\Species;

final class Output
{
    public function __construct(
        public readonly Species $species
    ) {
    }
}

