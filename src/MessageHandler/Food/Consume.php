<?php

declare(strict_types=1);

namespace App\MessageHandler\Food;

use App\Entity\Dinosaur;
use App\Event\Food\HasBeenConsumed;
use App\Message\Food\Consume as FoodConsume;
use Doctrine\ORM\EntityManagerInterface;
use DomainException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;

#[AsMessageHandler]
class Consume
{
    public function __construct(
        private EntityManagerInterface $em,
        private MessageBusInterface $eventBus,
        private LoggerInterface $logger
    ) {
    }

    public function __invoke(FoodConsume $message)
    {
        $dinosaurId = $message->dinosaurId;

        $dinosaursRepository = $this->em->getRepository(Dinosaur::class);

        /** @var Dinosaur $dinosaur */
        $dinosaur = $dinosaursRepository->find($dinosaurId);

        $park = $dinosaur->getPark();

        $consumedAmout = random_int(1, 10);

        if ($consumedAmout > $park->getFoodAmount()) {
            throw new DomainException(sprintf(
                'Not enough food to feed %s',
                $dinosaur->getName()
            ));
        }

        $this->logger->info(sprintf(
            '%s is consuming %d stacks of food. He needs to rest...',
            $dinosaur->getName(),
            $consumedAmout
        ));

        sleep($consumedAmout);

        $park->setFoodAmount($park->getFoodAmount() - $consumedAmout);

        $envelop = new Envelope(new HasBeenConsumed($park->getId()));

        $this
            ->eventBus
            ->dispatch($envelop->with(new DispatchAfterCurrentBusStamp()))
        ;
    }
}
