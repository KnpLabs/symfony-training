<?php

namespace App\MessageHandler\Dinosaur;

use App\Entity\Dinosaur;
use App\Event\Dinosaur\HasBeenCreated;
use App\Message\Dinosaur\Create as CreateMessage;
use App\MessageResults\Dinosaur\Create as CreateMessageResult;
use App\Repository\DinosaurRepository;
use App\Repository\ParkRepository;
use App\Repository\SpeciesRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;

#[AsMessageHandler]
final class Create
{
    public function __construct(
        private DinosaurRepository $dinosaurRepository,
        private SpeciesRepository $speciesRepository,
        private ParkRepository $parkRepository,
        private MessageBusInterface $eventBus
    ) {
    }

    public function __invoke(CreateMessage $message)
    {
        if (!$species = $this->speciesRepository->find($message->speciesId)) {
            throw new NotFoundHttpException("Species with id {$message->speciesId} not found");
        }

        if (!$park = $this->parkRepository->find($message->parkId)) {
            throw new NotFoundHttpException("Park with id {$message->parkId} not found");
        }

        $dino = new Dinosaur(
            name: $message->name,
            gender: $message->gender,
            species: $species,
            age: $message->age,
            eyesColor: $message->eyesColor,
            park: $park
        );

        $this->dinosaurRepository->add($dino, flush: true);

        $envelop = new Envelope(new HasBeenCreated($dino->getId()));

        $this
            ->eventBus
            ->dispatch($envelop->with(new DispatchAfterCurrentBusStamp()))
        ;

        return new CreateMessageResult($dino->getId());
    }
}
