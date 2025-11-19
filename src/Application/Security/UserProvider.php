<?php

declare(strict_types=1);

namespace Application\Security;

use Domain\Collection\UsersCollection;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class UserProvider implements UserProviderInterface
{
    public function __construct(
        private readonly UsersCollection $users
    ) {
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $user = $this->users->findOneByEmail($identifier);

        if (null === $user) {
            throw new UserNotFoundException();
        }

        return new User($user);
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        return $this->loadUserByIdentifier(
            $user->getUserIdentifier()
        );
    }

    public function supportsClass($class): bool
    {
        return User::class === $class;
    }
}
