<?php

declare(strict_types=1);

namespace App\Event\Species;

use App\Event\AbstractEvent;
use App\Event\AsyncLowPriorityEvent;

class HasBeenDeleted extends AbstractEvent implements AsyncLowPriorityEvent
{
}
