<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Reservation;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    public function findByBuyer(User $buyer): array
    {
        return $this->createQueryBuilder('reservation')
            ->where('reservation.user_id = :buyer')
            ->setParameter('buyer', $buyer)
            ->getQuery()
            ->getResult()
        ;
    }
}