<?php

namespace App\MessageHandler\Species;

use App\Entity\Species;
use App\Event\Species\HasBeenCreated;
use App\Message\Species\Create as CreateMessage;
use App\MessageResults\Species\Create as CreateMessageResult;
use App\Repository\SpeciesRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;
use Symfony\Component\Uid\Uuid;

#[AsMessageHandler]
final class Create
{
    public function __construct(
        private SpeciesRepository $speciesRepository,
        private MessageBusInterface $eventBus
    ) {
    }

    public function __invoke(CreateMessage $message): CreateMessageResult
    {
        $species = new Species(
            name: $message->name,
            habitats: $message->habitats,
            feeding: $message->feeding
        );

        $this->speciesRepository->add($species, flush: true);

        $envelop = new Envelope(new HasBeenCreated(
            $species->getId()
        ));

        $this
            ->eventBus
            ->dispatch($envelop->with(new DispatchAfterCurrentBusStamp()))
        ;

        return new CreateMessageResult($species->getId());
    }
}
