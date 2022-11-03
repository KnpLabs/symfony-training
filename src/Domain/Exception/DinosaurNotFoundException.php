<?php

declare(strict_types=1);

namespace Domain\Exception;

use DomainException;

class DinosaurNotFoundException extends DomainException
{
    public function __construct(
        public readonly string $id
    ) {
        parent::__construct(sprintf('Dinosaur with id "%s" not found', $id));
    }
}
