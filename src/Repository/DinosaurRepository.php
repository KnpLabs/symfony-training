<?php

namespace App\Repository;

use App\Entity\Dinosaur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DinosaurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dinosaur::class);
    }

    public function add(Dinosaur $dinosaur, bool $flush = false): void
    {
        $this->getEntityManager()->persist($dinosaur);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function search(?string $q): array
    {
        if ($q === null) {
            return $this->findAll();
        }

        return $this->createQueryBuilder('d')
            ->where('d.name = :q')
            ->setParameter('q', $q)
            ->getQuery()
            ->getResult()
        ;
    }
}
