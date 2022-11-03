<?php

declare(strict_types=1);

namespace Infrastructure\Doctrine\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Domain\Collection\UsersCollection;
use Domain\Model\User;

class UserRepository extends ServiceEntityRepository implements UsersCollection
{
    private ObjectManager $objectManager;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
        $this->objectManager = $registry->getManager();
    }

    public function findByEmail(string $email): ?User
    {
        return $this->createQueryBuilder('u')
            ->where('u.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function add(User $user): void
    {
        $this->objectManager->persist($user);
        $this->objectManager->flush();
    }
}
