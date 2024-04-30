<?php

declare(strict_types=1);

namespace Domain\UseCase\CreateDinosaur;

use Domain\Collection\DinosaursCollection;
use Domain\Collection\SpeciesCollection;
use Domain\Event\DinosaurIsBorn;
use Domain\EventsRegisterer;
use Domain\Exception\DinosaurAlreadyExistsException;
use Domain\Exception\SpeciesNotFoundException;
use Domain\Model\Dinosaur;

final class Handler
{
    public function __construct(
        private readonly DinosaursCollection $dinosaursCollection,
        private readonly SpeciesCollection $speciesCollection,
        private readonly EventsRegisterer $eventsRegisterer
    ) {
    }

    public function __invoke(Input $input): Output
    {
        $existingDinosaurs = $this
            ->dinosaursCollection
            ->findByName($input->name);

        if (null !== $existingDinosaurs) {
            throw new DinosaurAlreadyExistsException($input->name);
        }

        $species = $this
            ->speciesCollection
            ->find($input->speciesId);

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

        $this->eventsRegisterer->register(new DinosaurIsBorn($dinosaur->getId()));

        return new Output($dinosaur);
    }
}
