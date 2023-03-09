<?php

declare(strict_types=1);

namespace App\Event\AbstractEvent;

use App\Event\AbstractEvent;
use App\Event\AsyncLowPriorityEvent;

class HasBeenRefilled extends AbstractEvent implements AsyncLowPriorityEvent
{
}
