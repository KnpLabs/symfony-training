<?php

declare(strict_types=1);

namespace Domain\Collection;

use Domain\Model\Dinosaur;

interface DinosaursCollection
{
    public function find(string $id);

    /**
     * @return array<Dinosaur>
     */
    public function search(?string $q): array;
}
