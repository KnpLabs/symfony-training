<?php

declare(strict_types=1);

namespace Application\Security;

use Domain\Model\User as ModelUser;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    public function __construct(
        private readonly ModelUser $user
    ) {
    }

    public function getRoles(): array
    {
        return $this->user->getRoles();
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->user->getEmail();
    }

    public function getPassword(): ?string
    {
        return $this->user->getPassword();
    }
}
