<?php

declare(strict_types=1);

namespace App\MessageHandler\Food;

use App\Entity\Park;
use App\Message\Food\Refill as FoodRefill;
use Doctrine\ORM\EntityManagerInterface;
use DomainException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class Refill
{
    public function __construct(
        private LoggerInterface $logger,
        private EntityManagerInterface $entityManager
    ) {
    }

    public function __invoke(FoodRefill $refill)
    {
        $this->logger->info('Refilling food');

        $parkRepository = $this->entityManager->getRepository(Park::class);

        $parks = $parkRepository->findAll();

        $dinosaurIsAttacking = random_int(0, 10);

        if ($dinosaurIsAttacking < 5) {
            throw new DomainException('Dinosaur is attacking cannot refill food');
        }

        foreach ($parks as $park) {
            $park->setFoodAmount(100);
        }

        $this->entityManager->flush();
    }
}
