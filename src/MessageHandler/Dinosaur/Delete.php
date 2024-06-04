<?php

namespace App\MessageHandler\Dinosaur;

use App\Entity\Dinosaur;
use App\Event\Dinosaur\HasBeenDeleted;
use App\Message\Dinosaur\Delete as DeleteMessage;
use App\Repository\DinosaurRepository;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;

#[AsMessageHandler]
final class Delete
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private MessageBusInterface $eventBus,
        private DinosaurRepository $dinosaurRepository
    ) {
    }

    public function __invoke(DeleteMessage $message)
    {
        if (!$dinosaur = $this->dinosaurRepository->find($message->id)) {
            throw new NotFoundHttpException("Dinosaur with id {$message->id} not found");
        }

        $this->entityManager->remove($dinosaur);

        $envelop = new Envelope(
            new HasBeenDeleted($message->id)
        );

        $this->eventBus->dispatch(
            $envelop->with(new DispatchAfterCurrentBusStamp())
        );
    }
}
