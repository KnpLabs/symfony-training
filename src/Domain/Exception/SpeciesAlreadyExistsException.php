<?php

declare(strict_types=1);

namespace Domain\Exception;

use DomainException;

class SpeciesAlreadyExistsException extends DomainException
{
    public function __construct(string $name)
    {
        parent::__construct(sprintf('Species "%s" already exists', $name));
    }
}
