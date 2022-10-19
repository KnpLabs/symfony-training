<?php

declare(strict_types=1);

namespace Domain\Collection;

use Domain\Model\Species;

interface SpeciesCollection
{
    public function find(string $id);

    /**
     * @return array<Species>
     */
    public function findAll(): array;

    public function add(Species $species): void;

    public function remove(Species $species): void;
}

