<?php

declare(strict_types=1);

namespace App\Validator\JsonSchema;

final readonly class Error
{
    public function __construct(
        private string $path,
        private string $message
    ) {
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
