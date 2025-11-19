<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Form\Type\SpeciesType;
use Application\MessageBus\CommandBus;
use Application\MessageBus\QueryBus;
use Domain\Exception\SpeciesAlreadyExistsException;
use Domain\Exception\SpeciesNotFoundException;
use Domain\Query\GetAllSpecies;
use Domain\Query\GetSingleSpecies;
use Domain\UseCase\CreateSpecies;
use Domain\UseCase\EditSpecies;
use Domain\UseCase\RemoveSpecies;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SpeciesController extends AbstractController
{
    public function __construct(
        private readonly CommandBus $commandBus,
        private readonly QueryBus $queryBus
    ) {
    }

    #[Route('/species', name: 'app_list_species')]
    public function list(): Response
    {
        $speciesList = $this->queryBus->dispatch(new GetAllSpecies\Query());

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
            $rawSpecies = $form->getData();

            $input = new CreateSpecies\Input(
                name: $rawSpecies['name'],
                habitats: $rawSpecies['habitats'],
                feeding: $rawSpecies['feeding']
            );

            try {
                $output = $this->commandBus->dispatch($input);

                $this->addFlash('success', 'The species has been created!');

                return $this->redirectToRoute('app_list_species');
            } catch (SpeciesAlreadyExistsException $e) {
                $this->addFlash('error', $e->getMessage());
            }
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
    public function edit(Request $request, string $id): Response
    {
        try {
            $species = $this->queryBus->dispatch(new GetSingleSpecies\Query($id));
        } catch (SpeciesNotFoundException $e) {
            throw $this->createNotFoundException(
                'The species you are looking for does not exists.'
            );
        }

        $form = $this->createForm(SpeciesType::class, $species);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $species = $form->getData();

            $input = EditSpecies\Input::fromReadModel($species);

            try {
                $this->commandBus->dispatch($input);

                $this->addFlash('success', 'The species has been updated!');

                return $this->redirectToRoute('app_list_species');
            } catch (SpeciesAlreadyExistsException $e) {
                $this->addFlash('error', $e->getMessage());
            } catch (SpeciesNotFoundException $e) {
                throw $this->createNotFoundException($e->getMessage());
            }
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
        try {
            $this->commandBus->dispatch(new RemoveSpecies\Input($id));
        } catch (SpeciesNotFoundException $e) {
            throw $this->createNotFoundException($e->getMessage());
        }

        $this->addFlash('success', 'The species has been removed!');

        return $this->redirectToRoute('app_list_species');
    }
}
