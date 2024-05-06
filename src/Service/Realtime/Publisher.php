<?php

declare(strict_types=1);

namespace App\Service\Realtime;

use App\Realtime\Trigger;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;

final readonly class Publisher
{
    public function __construct(
        private HubInterface $hub
    ) {
    }

    public function publish(Trigger $trigger): void
    {
        $this->hub->publish(new Update(
            $trigger->topics,
            json_encode($trigger),
            type: $trigger->type
        ));
    }
}
