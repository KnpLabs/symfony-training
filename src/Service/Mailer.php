<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Message;

class Mailer
{
    public function __construct(private readonly MailerInterface $mailer)
    {
    }

    public function sendCreatedDinosaurEmail(): void
    {
        $email = (new Email())
            ->from('hello@knplabs.com')
            ->to('edgar@knplabs.com')
            ->subject('New dinosaur has been created !')
            ->text('Congratulations, you juste created a new dinosaur !')
        ;

        $this->sendEmail($email);
    }

    private function sendEmail(Message $email): Response
    {
        $this->mailer->send($email);

        return new Response('Email sent !');
    }
}
