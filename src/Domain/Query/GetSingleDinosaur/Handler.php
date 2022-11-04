<?php

declare(strict_types=1);

namespace Domain\Query\GetSingleDinosaur;

use Domain\Collection\DinosaursCollection;
use Domain\Exception\DinosaurNotFoundException;
use Domain\ReadModel\Dinosaur;

class Handler
{
    public function __construct(
        private DinosaursCollection $dinosaursCollection
    ) {
    }

    public function __invoke(Query $query): Dinosaur
    {
        $dinosaur = $this->dinosaursCollection->find($query->id);

        if ($dinosaur === null) {
            throw new DinosaurNotFoundException($query->id);
        }

        return new Dinosaur($dinosaur);
    }
}
