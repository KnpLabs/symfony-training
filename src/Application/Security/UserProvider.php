<?php

declare(strict_types=1);

namespace Application\Security;

use Domain;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class UserProvider implements UserProviderInterface
{
    /**
     * @var Domain\Repository\Users
     */
    private $users;

    public function __construct(Domain\Collection\UsersCollection $users)
    {
        $this->users = $users;
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $user = $this->users->findOneByEmail($identifier);

        if (null === $user) {
            throw new UserNotFoundException();
        }

        return new User($user);
    }

    public function refreshUser(UserInterface $user)
    {
        return $this->loadUserByIdentifier(
            $user->getUserIdentifier()
        );
    }

    public function supportsClass($class)
    {
        return User::class === $class;
    }
}

