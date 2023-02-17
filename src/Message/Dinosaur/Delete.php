<?php

namespace App\Message\Dinosaur;

class Delete
{
    public function __construct(
        public readonly string $id
    ) {
    }
}
