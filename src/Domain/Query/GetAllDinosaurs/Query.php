<?php

declare(strict_types=1);

namespace Domain\Query\GetAllDinosaurs;

final class Query
{
    public function __construct(
        public readonly ?string $search = null
    ) {
    }
}
