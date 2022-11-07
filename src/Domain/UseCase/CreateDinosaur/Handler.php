<?php

declare(strict_types=1);

namespace Domain\UseCase\CreateDinosaur;

use Domain\Collection\DinosaursCollection;
use Domain\Collection\SpeciesCollection;
use Domain\Event\DinosaurIsBorn;
use Domain\Exception\DinosaurAlreadyExistsException;
use Domain\Exception\SpeciesNotFoundException;
use Domain\HasEventsRegisterer;
use Domain\Model\Dinosaur;

class Handler
{
    use HasEventsRegisterer;

    public function __construct(
        private DinosaursCollection $dinosaursCollection,
        private SpeciesCollection $speciesCollection
    ) {
    }

    public function __invoke(Input $input): Output
    {
        $existingDinosaurs = $this
            ->dinosaursCollection
            ->findByName($input->name)
        ;

        if (null !== $existingDinosaurs) {
            throw new DinosaurAlreadyExistsException($input->name);
        }

        $species = $this
            ->speciesCollection
            ->find($input->speciesId)
        ;

        if (null === $species) {
            throw new SpeciesNotFoundException($input->speciesId);
        }

        $dinosaur = new Dinosaur(
            $input->name,
            $input->gender,
            $species,
            $input->age,
            $input->eyesColor
        );

        $this->dinosaursCollection->add($dinosaur);

        $this->registerEvents(new DinosaurIsBorn($dinosaur));

        return new Output($dinosaur);
    }
}
