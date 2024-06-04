<?php

declare(strict_types=1);

namespace App\EventHandler\Dinosaur;

use App\Indexer;
use App\Event\Dinosaur\HasBeenDeleted as DinosaurHasBeenDeleted;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

class DeleteDinosaurSummary
{
    public function __construct(
        private Indexer $indexer
    ) {
    }

    #[AsMessageHandler]
    public function handleDinosaurHasBeenDeleted(DinosaurHasBeenDeleted $event): void
    {
        $this->indexer->delete($event->getId());
    }
}
