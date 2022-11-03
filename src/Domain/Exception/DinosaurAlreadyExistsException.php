<?php

declare(strict_types=1);

namespace Domain\Exception;

use DomainException;

class DinosaurAlreadyExistsException extends DomainException
{
    public function __construct(string $name)
    {
        parent::__construct(sprintf('Dinosaur "%s" already exists', $name));
    }
}
