<?php

declare(strict_types=1);

namespace Domain\Exception;

use DomainException;

class SpeciesNotFoundException extends DomainException
{
    public function __construct(string $id)
    {
        parent::__construct(sprintf('Species with id "%s" already exists', $id));
    }
}

