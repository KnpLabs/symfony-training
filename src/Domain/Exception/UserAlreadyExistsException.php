<?php

declare(strict_types=1);

namespace Domain\Exception;

use DomainException;

class UserAlreadyExistsException extends DomainException
{
    public function __construct(string $email)
    {
        parent::__construct(sprintf('User "%s" already exists', $email));
    }
}

