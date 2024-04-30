<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Form\Type\UserType;
use Application\MessageBus\CommandBus;
use Domain\Collection\UsersCollection;
use Domain\Exception\UserAlreadyExistsException;
use Domain\UseCase\RegisterUser\Input;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class AuthenticationController extends AbstractController
{
    public function __construct(
        private readonly UsersCollection $usersCollection,
        private readonly CommandBus $commandBus
    ) {
    }

    #[Route('/register', name: 'register')]
    public function register(Request $request): Response
    {
        $form = $this->createForm(UserType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $input = new Input(
                email: $user['email'],
                password: $user['password'],
            );

            try {
                $this->commandBus->dispatch($input);

                $this->addFlash('success', 'You have been sucessfully registered!');

                return $this->redirectToRoute('login');
            } catch (UserAlreadyExistsException $e) {
                $this->addFlash('danger', 'The email is already in use.');
            }
        }

        return $this->render('register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login.html.twig', [
            'controller_name' => 'AuthenticationController',
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }
}
