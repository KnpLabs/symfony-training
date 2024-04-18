<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Entity\Dinosaur;
use App\Entity\User;

final readonly class Mailer
{
    public function __construct(
        private MailerInterface $mailer
    ) {
    }

    public function sendDinausorHasBeenCreatedEmail(
        Dinosaur $dinosaur,
        User $user
    ): void {
        $email = (new Email())
            ->subject('Your dinosaur has been created !')
            ->to($user->getUserIdentifier())
            ->html('<p>Congratulations ! ' . $dinosaur->getName() . ' has been created ! It is now part of your collection !</p>');

        $this->send($email);
    }

    private function send(Email $email): void
    {
        $this->mailer->send($email);
    }
}
