<?php

namespace App\Twig;

use App\Entity\Dinosaur;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class DinosaurExtension extends AbstractExtension
{
    /**
     * {@inheritDoc}
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('under', [$this, 'underAge'])
        ];
    }

    /**
     * @param Dinosaur[] $dinosaurs
     *
     * @return Dinosaur[]
     */
    public function underAge(array $dinosaurs, int $ageThreshold): array
    {
        return array_filter(
            $dinosaurs,
            fn (Dinosaur $dinosaur): bool => $dinosaur->getAge() < $ageThreshold
        );
    }
}
