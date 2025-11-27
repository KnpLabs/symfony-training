<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HelloWorldController extends AbstractController
{
    #[Route('/hello-world', name: 'app_hello_world')]
    public function list(): Response
    {
        return $this->render('hello-world.html.twig');
    }
}
