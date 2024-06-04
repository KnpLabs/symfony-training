<?php

declare(strict_types=1);

namespace App\Realtime\Trigger;

use App\Realtime\Trigger;

final readonly class UserLoggetIn extends Trigger
{
    public function __construct(string $userIdentifier)
    {
        parent::__construct(
            'login',
            ['http://localhost/activity'],
            [
                'userIdentifier' => $userIdentifier,
                'message' => "The user {$userIdentifier} has been logged in !"
            ]
        );
    }
}
