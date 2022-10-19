<?php

declare(strict_types=1);

namespace Infrastructure\Doctrine\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Domain\Collection\SpeciesCollection;
use Domain\Model\Species;

final class SpeciesRepository extends ServiceEntityRepository implements SpeciesCollection
{
    private ObjectManager $objectManager;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Species::class);
        $this->objectManager = $registry->getManager();
    }

    public function add(Species $species): void
    {
        $this->objectManager->persist($species);
        $this->objectManager->flush();
    }

    public function remove(Species $species): void
    {
        $this->objectManager->remove($species);
        $this->objectManager->flush();
    }
}
