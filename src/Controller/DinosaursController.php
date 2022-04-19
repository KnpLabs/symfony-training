<?php

namespace App\Controller;

use App\Entity\Dinosaur;
use App\Form\Type\DinosaurType;
use App\Form\Type\SearchType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DinosaursController extends AbstractController
{
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

        return $this->render('dinosaurs-list.html.twig', [
            'dinosaurs' => $dinosaurs,
            'searchForm' => $form->createView(),
        ]);
    }

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
