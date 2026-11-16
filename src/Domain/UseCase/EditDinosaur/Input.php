<?php

declare(strict_types=1);

namespace Domain\UseCase\EditDinosaur;

use DateTime;
use Domain\ReadModel\Dinosaur;

final readonly class Input
{


    public function __construct(
        public string    $id,
        public string    $name,
        public string    $gender,
        public string $speciesId,
        public int       $age,
        public DateTime  $birthDate,
        public string    $eyesColor,

    ) {
    }

    public static function fromReadModel(Dinosaur $dinosaur): self
    {
        return new self(
            (string) $dinosaur->getId(),
            $dinosaur->getName(),
            $dinosaur->getGender(),
            (string) $dinosaur->getSpecies()->getId(),
            $dinosaur->getAge(),
            $dinosaur->getBirthDate(),
            $dinosaur->getEyesColor()
        );
    }
}
