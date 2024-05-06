<?php

declare(strict_types=1);

namespace App\Realtime\Trigger;

use App\Entity\Dinosaur;
use App\Realtime\Trigger;

class DinosaurUpdated extends Trigger
{
    public function __construct(
        Dinosaur $dinosaur,
        string $oldName,
        string $link
    ) {
        parent::__construct(
            'updated',
            ['http://localhost/dinosaurs'],
            [
                'id' => $dinosaur->getId(),
                'name' => $dinosaur->getName(),
                'link' => $link,
                'message' => "The dinosaur {$oldName} has been edited !"
            ]
        );
    }
}
