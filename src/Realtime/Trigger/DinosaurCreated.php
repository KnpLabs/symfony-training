<?php

declare(strict_types=1);

namespace App\Realtime\Trigger;

use App\Entity\Dinosaur;
use App\Realtime\Trigger;

final readonly class DinosaurCreated extends Trigger
{
    public function __construct(
        Dinosaur $dinosaur,
        string $link
    ) {
        parent::__construct(
            'created',
            ['http://localhost/dinosaurs'],
            [
                'id' => $dinosaur->getId(),
                'name' => $dinosaur->getName(),
                'link' => $link,
                'message' => "The dinosaur {$dinosaur->getName()} has been created !"
            ]
        );
    }
}
