<?php

declare(strict_types=1);

namespace Domain\Exception;

use DomainException;

final class SpeciesNotFoundException extends DomainException
{
    public function __construct(
        private readonly string $id
    ) {
        parent::__construct(sprintf('Species with id "%s" already exists', $id));
    }
}
