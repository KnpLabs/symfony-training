<?php

declare(strict_types=1);

namespace Domain\Query\GetSingleSpecies;

final readonly class Query
{
    public function __construct(
        public string $id,
    ) {
    }
}
