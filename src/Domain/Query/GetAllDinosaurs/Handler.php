<?php

declare(strict_types=1);

namespace Domain\Query\GetAllDinosaurs;

use Domain\Collection\DinosaursCollection;
use Domain\Model\Dinosaur as ModelDinosaur;
use Domain\ReadModel\Dinosaur;

class Handler
{
    public function __construct(
        private DinosaursCollection $dinosaursCollection
    ) {
    }

    public function __invoke(Query $query): array
    {
        $dinosaurs = $this->dinosaursCollection->search($query->search);

        return array_map(
            fn (ModelDinosaur $dinosaur) => new Dinosaur($dinosaur),
            $dinosaurs
        );
    }
}
