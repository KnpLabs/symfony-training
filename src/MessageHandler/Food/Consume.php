<?php

declare(strict_types=1);

namespace App\MessageHandler\Food;

use App\Entity\Dinosaur;
use App\Message\Food\Consume as FoodConsume;
use Doctrine\ORM\EntityManagerInterface;
use DomainException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class Consume implements MessageHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private LoggerInterface $logger
    ) {
    }

    public function __invoke(FoodConsume $message)
    {
        $dinosaurId = $message->dinosaurId;

        $dinosaursRepository = $this->em->getRepository(Dinosaur::class);

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

        $this->em->flush();
    }
}
