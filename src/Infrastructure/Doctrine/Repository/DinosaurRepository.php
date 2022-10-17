<?php

namespace Infrastructure\Doctrine\Repository;

use Domain\Model\Dinosaur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;

class DinosaurRepository extends ServiceEntityRepository
{
    private ObjectManager $objectManager;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dinosaur::class);
        $this->objectManager = $registry->getManager();
    }

    public function search(?string $q): array
    {
        if (null === $q) {
            return $this->findAll();
        }

        return $this->createQueryBuilder('d')
            ->where('d.name = :q')
            ->setParameter('q', $q)
            ->getQuery()
            ->getResult();
    }

    public function add(Dinosaur $dinosaur): void
    {
        $this->objectManager->persist($dinosaur);
        $this->objectManager->flush();
    }

    public function remove(Dinosaur $dinosaur): void
    {
        $this->objectManager->remove($dinosaur);
        $this->objectManager->flush();
    }
}
