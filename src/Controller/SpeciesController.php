<?php

namespace App\Controller;

use App\Entity\Habitat;
use App\Entity\Species;
use App\Form\Type\SpeciesType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SpeciesController extends AbstractController
{
    public function getSpeciesList(?Habitat $habitat = null, ManagerRegistry $doctrine): Response
    {
        $speciesList = [];

        if (null !== $habitat) {
            $speciesList = $habitat->getSpecies();
        } else {
            $speciesList = $doctrine
                ->getRepository(Species::class)
                ->findAll();
        }

        return $this->render('_species-list.html.twig', [
            'speciesList' => $speciesList,
        ]);
    }

    #[Route('/species', name: 'app_list_species')]
    public function list(ManagerRegistry $doctrine): Response
    {
        $speciesList = $doctrine
            ->getRepository(Species::class)
            ->findAll();

        return $this->render('species-list.html.twig', [
            'speciesList' => $speciesList,
        ]);
    }

    #[Route('/species/create', name: 'app_create_species')]
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

        return $this->render('create-species.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route(
        '/species/{id}/edit',
        name: 'app_edit_species',
        requirements: ['id' => '\d+']
    )]
    public function edit(Request $request, int $id, ManagerRegistry $doctrine): Response
    {
        $species = $doctrine
            ->getRepository(Species::class)
            ->find($id);

        if (false === $species) {
            throw $this->createNotFoundException('The species you are looking for does not exists.');
        }

        $form = $this->createForm(SpeciesType::class, $species);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $species = $form->getData();

            $em->flush();

            $this->addFlash('success', 'The species has been edited!');

            return $this->redirectToRoute('app_list_species');
        }

        return $this->render('edit-species.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route(
        '/species/{id}/remove',
        name: 'app_remove_species',
        requirements: ['id' => '\d+']
    )]
    public function remove(int $id, ManagerRegistry $doctrine): Response
    {
        $species = $doctrine
            ->getRepository(Species::class)
            ->find($id);

        if (false === $species) {
            throw $this->createNotFoundException('The species you are looking for does not exists.');
        }

        $em = $doctrine->getManager();
        $em->remove($species);
        $em->flush();

        $this->addFlash('success', 'The species has been removed!');

        return $this->redirectToRoute('app_list_species');
    }
}
