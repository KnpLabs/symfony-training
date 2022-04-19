<?php

namespace App\Controller;

use App\Entity\Species;
use App\Form\Type\SpeciesType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SpeciesController extends AbstractController
{
    public function list(ManagerRegistry $doctrine): Response
    {
        $speciesList = $doctrine
            ->getRepository(Species::class)
            ->findAll()
        ;

        return $this->render('species-list.html.twig', [
            'speciesList' => $speciesList
        ]);
    }

    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(SpeciesType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $species = $form->getData();

            $em->persist($species);
            $em->flush();

            $this->addFlash('success', 'The species has been created!');

            return $this->redirectToRoute('app_list_species');
        }

        return $this->renderForm('create-species.html.twig', [
            'form' =>  $form
        ]);
    }

    public function edit(Request $request, int $id, ManagerRegistry $doctrine): Response
    {
        $species = $doctrine
            ->getRepository(Species::class)
            ->find($id)
        ;

        if ($species === false) {
            throw $this->createNotFoundException(
                'The species you are looking for does not exists.'
            );
        }

        $form = $this->createForm(SpeciesType::class, $species);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $species = $form->getData();

            $em->flush();

            $this->addFlash('success', 'The species has been edited!');

            return $this->redirectToRoute('app_list_species');
        }

        return $this->renderForm('edit-species.html.twig', [
            'form' => $form,
        ]);
    }

    public function remove(int $id, ManagerRegistry $doctrine): Response
    {
        $species = $doctrine
            ->getRepository(Species::class)
            ->find($id)
        ;

        if ($species === false) {
            throw $this->createNotFoundException(
                'The species you are looking for does not exists.'
            );
        }

        $em = $doctrine->getManager();
        $em->remove($species);
        $em->flush();

        $this->addFlash('success', 'The species has been removed!');

        return $this->redirectToRoute('app_list_species');
    }
}
