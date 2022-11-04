<?php

declare(strict_types=1);

namespace Domain\Collection;

use Domain\Model\Dinosaur;

interface DinosaursCollection
{
    public function find(string $id);

    public function findByName(string $name): ?Dinosaur;

    /**
     * @return array<Dinosaur>
     */
    public function search(?string $q): array;

    public function add(Dinosaur $dinosaur): void;

    public function remove(Dinosaur $dinosaur): void;
}
