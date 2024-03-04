<?php

declare(strict_types=1);

namespace App\EventHandler\Dinosaur;

use App\Event\AbstractEvent\HasBeenRefilled;
use App\Event\Dinosaur\HasBeenCreated as DinosaurHasBeenCreated;
use App\Event\Dinosaur\HasBeenUpdated as DinosaurHasBeenUpdated;
use App\Event\Species\HasBeenUpdated as SpeciesHasBeenUpdated;
use App\Event\Food\HasBeenConsumed;
use App\Indexer;
use App\Repository\DinosaurRepository;
use App\Repository\SpeciesRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

class UpsertDinosaurSummary
{
    public function __construct(
        private Indexer $indexer,
        private DinosaurRepository $dinosaurRepository,
        private SpeciesRepository $speciesRepository
    ) {
    }

    #[AsMessageHandler]
    public function handleDinosaurHasBeenCreated(DinosaurHasBeenCreated $event): void
    {
        $this->updateSummaryByDinosaur($event->getId());
    }

    #[AsMessageHandler]
    public function handleDinosaurHasBeenUpdated(DinosaurHasBeenUpdated $event): void
    {
        $this->updateSummaryByDinosaur($event->getId());
    }

    #[AsMessageHandler]
    public function handleFoodHasBeenConsumed(HasBeenConsumed $event): void
    {
        $this->updateSummariesByPark($event->getId());
    }

    #[AsMessageHandler]
    public function handleFoodHasBeenRefilled(HasBeenRefilled $event): void
    {
        $this->updateSummariesByPark($event->getId());
    }

    #[AsMessageHandler]
    public function handleSpeciesHasBeenUpdated(SpeciesHasBeenUpdated $event): void
    {
        $speciesId = $event->getId();

        $species = $this ->speciesRepository->find($speciesId);

        if (null === $species) {
            throw new \RuntimeException(sprintf(
                'Species with id "%s" not found',
                $speciesId
            ));
        }

        $dinosaurs = $this->dinosaurRepository->findBySpecies($species);

        foreach ($dinosaurs as $dinosaur) {
            $this->indexer->indexFromDinosaur($dinosaur);
        }
    }

    private function updateSummaryByDinosaur(int $dinosaurId): void
    {
        $dinosaur = $this->dinosaurRepository->find($dinosaurId);

        if (null === $dinosaur) {
            throw new \RuntimeException(sprintf('Dinosaur with id "%s" not found', $dinosaurId));
        }

        $this->indexer->indexFromDinosaur($dinosaur);
    }

    private function updateSummariesByPark(int $parkId): void
    {
        $dinosaurs = $this->dinosaurRepository->findByPark($parkId);

        foreach ($dinosaurs as $dinosaur) {
            $this->indexer->indexFromDinosaur($dinosaur);
        }
    }
}
