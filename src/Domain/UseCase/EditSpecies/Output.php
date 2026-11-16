<?php

declare(strict_types=1);

namespace Domain\UseCase\EditSpecies;

use Domain\Model\Species;

final readonly class Output
{
    public function __construct(
        public Species $species
    ) {
    }
}
