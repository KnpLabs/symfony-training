<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Form\Type\SpeciesType;
use Domain\Collection\SpeciesCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SpeciesController extends AbstractController
{
    public function __construct(
        private SpeciesCollection $speciesCollection,
    ) {
    }

    #[Route('/species', name: 'app_list_species')]
    public function list(): Response
    {
        $speciesList = $this
            ->speciesCollection
            ->findAll();

        return $this->render('species-list.html.twig', [
            'speciesList' => $speciesList,
        ]);
    }

    #[Route('/species/create', name: 'app_create_species')]
    public function create(Request $request): Response
    {
        $form = $this->createForm(SpeciesType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $species = $form->getData();

            $this->speciesCollection->add($species);

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
    public function edit(Request $request, int $id): Response
    {
        $species = $this
            ->speciesCollection
            ->find($id);

        if (false === $species) {
            throw $this->createNotFoundException('The species you are looking for does not exists.');
        }

        $form = $this->createForm(SpeciesType::class, $species);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $species = $form->getData();

            $this->speciesCollection->add($species);

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
    public function remove(int $id): Response
    {
        $species = $this
            ->speciesCollection
            ->find($id);

        if (false === $species) {
            throw $this->createNotFoundException('The species you are looking for does not exists.');
        }

        $this->speciesCollection->remove($species);

        $this->addFlash('success', 'The species has been removed!');

        return $this->redirectToRoute('app_list_species');
    }
}
