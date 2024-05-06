<?php

declare(strict_types=1);

namespace App\Realtime;

use JsonSerializable;

abstract class Trigger implements JsonSerializable
{
    /**
     * @param array<string> $topics
     * @param array<mixed> $data
     */
    public function __construct(
        public string $type,
        public array $topics,
        private array $data
    ) {
    }

    public function jsonSerialize(): array
    {
        return $this->data;
    }
}
