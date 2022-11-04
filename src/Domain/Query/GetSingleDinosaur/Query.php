<?php

declare(strict_types=1);

namespace Domain\Query\GetSingleDinosaur;

final class Query
{
    public function __construct(
        public readonly string $id,
    ) {
    }
}
