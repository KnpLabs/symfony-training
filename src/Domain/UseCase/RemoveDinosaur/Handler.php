<?php

declare(strict_types=1);

namespace Domain\UseCase\RemoveDinosaur;

use Domain\Collection\DinosaursCollection;
use Domain\Event\DinosaurDied;
use Domain\Exception\DinosaurNotFoundException;
use Domain\HasEventsRegisterer;

class Handler
{
    use HasEventsRegisterer;

    public function __construct(
        private DinosaursCollection $dinosaursCollection
    ) {
    }

    public function __invoke(Input $input): Output
    {
        $dinosaur = $this
            ->dinosaursCollection
            ->find($input->id)
        ;

        if (null === $dinosaur) {
            throw new DinosaurNotFoundException($input->id);
        }

        $this->dinosaursCollection->remove($dinosaur);

        $this->registerEvents(new DinosaurDied($dinosaur));

        return new Output();
    }
}
