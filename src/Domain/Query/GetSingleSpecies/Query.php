<?php

declare(strict_types=1);

namespace Domain\Query\GetSingleSpecies;

final class Query
{
    public function __construct(
        public readonly string $id,
    ) {
    }
}
