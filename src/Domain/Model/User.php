<?php

declare(strict_types=1);

namespace Domain\Model;

class User
{
    private int $id;
    private ?string $password;

    public function __construct(
        private string $email,
        private array $roles = []
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setHashedPassword(string $hashedPassword): void
    {
        $this->password = $hashedPassword;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }
}
