<?php

declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    private int $id;
    private string $email;
    private ?string $password;

    public function __construct(
        string $email,
    ) {
        $this->email = $email;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserIdentifier(): string 
    { 
        return $this->email;
    }

    public function getRoles(): array 
    { 
        return ['ROLE_USER'];
    }
    
    public function setHashedPassword(string $hashedPassword): void
    {
        $this->password = $hashedPassword;
    }

    public function getPassword(): ?string 
    { 
        return $this->password;
    }

    public function eraseCredentials() 
    { 
    }
}
