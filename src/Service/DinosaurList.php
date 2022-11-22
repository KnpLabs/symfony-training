<?php

namespace App\Service;

use App\Entity\Dinosaur;
use Twig\Environment;

final class DinosaurList
{
    public function __construct(private readonly Environment $twig)
    {
    }

    /**
     * @param Dinosaur[] $dinosaurs
     */
    public function getList(array $dinosaurs): string
    {
        return $this->twig->render('dinosaurs-list.html.twig', [
            'dinosaurs' => $dinosaurs
        ]);
    }
}
