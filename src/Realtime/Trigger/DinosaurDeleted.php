<?php

declare(strict_types=1);

namespace App\Realtime\Trigger;

use App\Entity\Dinosaur;
use App\Realtime\Trigger;

final readonly class DinosaurDeleted extends Trigger
{
    public function __construct($id, Dinosaur $dinosaur)
    {
        parent::__construct(
            'deleted',
            ['http://localhost/dinosaurs'],
            [
                'id' => $id,
                'message' => "The dinosaur {$dinosaur->getName()} has been removed !"
            ]
        );
    }
}
