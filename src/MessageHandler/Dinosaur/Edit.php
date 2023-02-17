<?php

namespace App\MessageHandler\Dinosaur;

use App\Event\Dinosaur\HasBeenUpdated;
use App\Message\Dinosaur\Edit as EditMessage;
use App\Repository\DinosaurRepository;
use App\Repository\SpeciesRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;

#[AsMessageHandler]
final class Edit
{
    public function __construct(
        private MessageBusInterface $eventBus,
        private DinosaurRepository $dinosaurRepository,
        private SpeciesRepository $speciesRepository,
    ) {
    }

    public function __invoke(EditMessage $message)
    {
        if (!$dinosaur = $this->dinosaurRepository->find($message->id)) {
            throw new NotFoundHttpException("Dinosaur with id {$message->id} not found");
        }

        if (!$species = $this->speciesRepository->find($message->speciesId)) {
            throw new NotFoundHttpException("Species with id {$message->id} not found");
        }

        $dinosaur->setName($message->name);
        $dinosaur->setEyesColor($message->eyesColor);
        $dinosaur->setAge($message->age);
        $dinosaur->setSpecies($species);

        $envelop = new Envelope(new HasBeenUpdated($dinosaur->getId()->toRfc4122()));

        $this
            ->eventBus
            ->dispatch($envelop->with(new DispatchAfterCurrentBusStamp()))
        ;
    }
}
