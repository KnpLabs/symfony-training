<?php

namespace App\Controller;

use App\Entity\Habitat;
use App\Form\Type\HabitatType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HabitatsController extends AbstractController
{
    #[Route('/habitats', name: 'app_list_habitats')]
    public function list(ManagerRegistry $doctrine): Response
    {
        $habitatsList = $doctrine
            ->getRepository(Habitat::class)
            ->findAll();

        return $this->render('habitats-list.html.twig', [
            'habitatsList' => $habitatsList,
        ]);
    }

    #[Route('/habitats/create', name: 'app_create_habitat')]
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(HabitatType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $habitats = $form->getData();

            $em->persist($habitats);
            $em->flush();

            $this->addFlash('success', 'The habitat has been created!');

            return $this->redirectToRoute('app_list_habitats');
        }

        return $this->render('create-habitat.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route(
        '/habitats/{id}',
        name: 'app_habitat',
        requirements: ['id' => '\d+']
    )]
    public function view(int $id, ManagerRegistry $doctrine): Response
    {
        $habitat = $doctrine
            ->getRepository(Habitat::class)
            ->find($id);

        if (false === $habitat) {
            throw $this->createNotFoundException('The habitat you are looking for does not exists.');
        }

        return $this->render('habitat.html.twig', [
            'habitat' => $habitat,
        ]);
    }

    #[Route(
        '/habitats/{id}/remove',
        name: 'app_remove_habitat',
        requirements: ['id' => '\d+']
    )]
    public function remove(int $id, ManagerRegistry $doctrine): Response
    {
        $habitats = $doctrine
            ->getRepository(Habitat::class)
            ->find($id);

        if (false === $habitats) {
            throw $this->createNotFoundException('The habitat you are looking for does not exists.');
        }

        $em = $doctrine->getManager();
        $em->remove($habitats);
        $em->flush();

        $this->addFlash('success', 'The habitat has been removed!');

        return $this->redirectToRoute('app_list_habitats');
    }
}
