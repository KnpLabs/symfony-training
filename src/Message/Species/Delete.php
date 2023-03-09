<?php

namespace App\Message\Species;

class Delete
{
    public function __construct(
        public readonly string $id
    ) {
    }
}
