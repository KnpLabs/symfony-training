<?php

declare(strict_types=1);

namespace Domain\Model;

interface AggregateRoot
{
    public function getId(): int;
}

