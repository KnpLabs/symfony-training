<?php

namespace App;

use App\Entity\Dinosaur;

class DinosaursFinder
{
    /**
     * @param array<Dinosaur> $dinosaurs
     */
    public function adultOnly(array $dinosaurs): array
    {
        return array_filter($dinosaurs, function (Dinosaur $dinosaur) {
            return $dinosaur->getAge() >= 21;
        });
    }
}

