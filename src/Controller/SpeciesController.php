<?php

namespace App\Controller;

use App\Bus\CommandBus;
use App\Entity\Species;
use App\Form\Type\SpeciesType;
use App\Message\Species\Delete;
use App\Message\Species\Edit;
use App\Message\Species\Create;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SpeciesController extends AbstractController
{
    public function __construct(
        private CommandBus $bus
    ) {
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
            $data = $form->getData();

            $result =  $this->bus->dispatch(new Create(
                name: $data->getName(),
                feeding: $data->getFeeding(),
                habitats: $data->getHabitats()
            ));

            $this->addFlash('success', sprintf(
                'The species with id %s has been created!',
                $result->id
            ));

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
    public function edit(Request $request, string $id, ManagerRegistry $doctrine): Response
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
            $data = $form->getData();

            $this->bus->dispatch(new Edit(
                id: $id,
                name: $data->getName(),
                feeding: $data->getFeeding(),
                habitats: $data->getHabitats()
            ));

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
    public function remove(string $id): Response
    {
        $this->bus->dispatch(new Delete($id));

        $this->addFlash('success', 'The species has been removed!');

        return $this->redirectToRoute('app_list_species');
    }
}
