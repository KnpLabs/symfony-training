<?php

declare(strict_types=1);

namespace App\Event\Food;

use App\Event\AbstractEvent;
use App\Event\AsyncLowPriorityEvent;

class HasBeenConsumed extends AbstractEvent implements AsyncLowPriorityEvent
{
}
