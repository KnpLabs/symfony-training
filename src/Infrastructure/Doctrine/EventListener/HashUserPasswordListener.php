<?php

declare(strict_types=1);

namespace Infrastructure\Doctrine\EventListener;

use Application\Security\User as SecurityUser;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Domain\Model\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class HashUserPasswordListener
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function __invoke(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof User) {
            return;
        }

        $plainPassword = $entity->getPlainPassword();

        if (null === $plainPassword) {
            return;
        }

        $securityUser = new SecurityUser($entity);

        $hashedPassword = $this->passwordHasher->hashPassword($securityUser, $plainPassword);

        $entity->setHashedPassword($hashedPassword);
    }
}
