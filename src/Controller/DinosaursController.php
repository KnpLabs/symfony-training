<?php

namespace App\Controller;

use App\Entity\Dinosaur;
use App\Form\Type\DinosaurType;
use App\Form\Type\SearchType;
use App\Service\DinosaurList;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DinosaursController extends AbstractController
{
    public function __construct(private DinosaurList $dinosaurService)
    {
    }

    #[Route('/dinosaurs', name: 'app_list_dinosaurs')]
    public function list(Request $request, ManagerRegistry $doctrine): Response
    {
        $q = null;
        $form = $this->createForm(SearchType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData();

            $q = $search['q'];
        }

        $dinosaurs = $doctrine
            ->getRepository(Dinosaur::class)
            ->search($q)
        ;

        return new Response($this->dinosaurService->getList($dinosaurs));
    }

    #[Route(
        '/dinosaurs/{id}',
        name: 'app_single_dinosaur',
        requirements: ['id' => '\d+']
    )]
    public function single(string $id, ManagerRegistry $doctrine): Response
    {
        $dinosaur = $doctrine
            ->getRepository(Dinosaur::class)
            ->find($id)
        ;

        if ($dinosaur === false) {
            throw $this->createNotFoundException(
                'The dinosaur you are looking for does not exists.'
            );
        }

        return $this->render('dinosaur.html.twig', [
            'dinosaur' => $dinosaur
        ]);
    }

    #[Route('/dinosaurs/create', name: 'app_create_dinosaur')]
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(DinosaurType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $dinosaur = $form->getData();

            $em->persist($dinosaur);
            $em->flush();

            $this->addFlash('success', 'The dinosaur has been created!');

            return $this->redirectToRoute('app_list_dinosaurs');
        }

        return $this->renderForm('create-dinosaur.html.twig', [
          'form' => $form
        ]);
    }

    #[Route(
        '/dinosaurs/{id}/edit',
        name: 'app_edit_dinosaur',
        requirements: ['id' => '\d+']
    )]
    public function edit(Request $request, int $id, ManagerRegistry $doctrine): Response
    {
        $dinosaur = $doctrine
            ->getRepository(Dinosaur::class)
            ->find($id)
        ;

        if ($dinosaur === false) {
            throw $this->createNotFoundException(
                'The dinosaur you are looking for does not exists.'
            );
        }

        $form = $this->createForm(DinosaurType::class, $dinosaur);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $dinosaur = $form->getData();

            $em->flush();

            $this->addFlash('success', 'The dinosaur has been edited!');

            return $this->redirectToRoute('app_list_dinosaurs');
        }

        return $this->renderForm('edit-dinosaur.html.twig', [
          'form' => $form
        ]);
    }

    #[Route(
        '/dinosaurs/{id}/remove',
        name: 'app_remove_dinosaur',
        requirements: ['id' => '\d+']
    )]
    public function remove(int $id, ManagerRegistry $doctrine): Response
    {
        $dinosaur = $doctrine
            ->getRepository(Dinosaur::class)
            ->find($id)
        ;

        if ($dinosaur === false) {
            throw $this->createNotFoundException(
                'The dinosaur you are looking for does not exists.'
            );
        }

        $em = $doctrine->getManager();
        $em->remove($dinosaur);
        $em->flush();

        $this->addFlash('success', 'The dinosaur has been removed!');

        return $this->redirectToRoute('app_list_dinosaurs');
    }
}
