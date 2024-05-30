<?php

declare(strict_types=1);

namespace App\Twig\Extensions;

use App\Entity\Dinosaur;
use Twig\Extension\RuntimeExtensionInterface;

class DinosaurRuntime implements RuntimeExtensionInterface
{
    /**
     * @param Dinosaur[] $dinosaurs
     *
     * @return Dinosaur[]
     */
    public function onlyAdult(array $dinosaurs): array
    {
        return array_filter(
            $dinosaurs,
            fn (Dinosaur $dinosaur): bool => $dinosaur->getAge() >= 18
        );
    }
}
