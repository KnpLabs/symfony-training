<?php

namespace App\Repository;

use App\Entity\Species;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class SpeciesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Species::class);
    }

    public function add(Species $species, bool $flush = false): void
    {
        $this->getEntityManager()->persist($species);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
