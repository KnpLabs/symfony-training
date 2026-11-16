<?php

declare(strict_types=1);

namespace Domain\UseCase\CreateDinosaur;

use DateTime;

final readonly class Input
{


    public function __construct(
        public string $name,
        public string $gender,
        public string $speciesId,
        public int $age,
        public DateTime $birthDate,
        public string $eyesColor
    ) {
    }
}
