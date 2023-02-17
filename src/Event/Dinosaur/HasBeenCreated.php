<?php

declare(strict_types=1);

namespace App\Event\Dinosaur;

use App\Event\AbstractEvent;
use App\Event\AsyncLowPriorityEvent;

class HasBeenCreated extends AbstractEvent implements AsyncLowPriorityEvent
{
}
