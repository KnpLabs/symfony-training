<?php

namespace App\MessageHandler\Species;

use App\Event\Species\HasBeenUpdated;
use App\Message\Species\Edit as EditMessage;
use App\Repository\SpeciesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;

#[AsMessageHandler]
final class Edit
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SpeciesRepository $speciesRepository,
        private MessageBusInterface $eventBus
    ) {
    }

    public function __invoke(EditMessage $message): void
    {
        if (!$species = $this->speciesRepository->find($message->id)) {
            throw new NotFoundHttpException("Species with id {$message->id} not found");
        }

        $species->setName($message->name);
        $species->setFeeding($message->feeding);
        $species->setHabitats($message->habitats);

        $envelop = new Envelope(new HasBeenUpdated($message->id));

        $this
            ->eventBus
            ->dispatch($envelop->with(new DispatchAfterCurrentBusStamp()))
        ;
    }
}
