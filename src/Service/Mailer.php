<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Entity\Dinosaur;
use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

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
        $email = (new TemplatedEmail())
            ->subject('Your dinosaur has been created !')
            ->to($user->getUserIdentifier())
            ->htmlTemplate('emails/dinosaur_has_been_created.html.twig')
            ->context(['dinosaur' => $dinosaur]);

        $this->send($email);
    }

    private function send(Email $email): void
    {
        $this->mailer->send($email);
    }
}
