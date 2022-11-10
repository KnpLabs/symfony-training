<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Message;

class Mailer
{
    public function __construct(private readonly MailerInterface $mailer)
    {
    }

    public function sendCreatedDinosaurEmail(string $name): void
    {
        $email = (new TemplatedEmail())
            ->from('hello@knplabs.com')
            ->to('edgar@knplabs.com')
            ->subject('New dinosaur has been created !')
            ->htmlTemplate('emails/validate-creation.html.twig')
            ->context(['dinosaur' => $name])
        ;

        $this->sendEmail($email);
    }

    private function sendEmail(Message $email): Response
    {
        $this->mailer->send($email);

        return new Response('Email sent !');
    }
}
