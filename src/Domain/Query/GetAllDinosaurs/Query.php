<?php

declare(strict_types=1);

namespace Domain\Query\GetAllDinosaurs;

final readonly class Query
{
    public function __construct(
        public ?string $search = null
    ) {
    }
}
