<?php

namespace Application\Controller;

use Application\Form\Type\DinosaurType;
use Application\Form\Type\SearchType;
use Application\MessageBus\CommandBus;
use Application\MessageBus\QueryBus;
use Domain\Exception\DinosaurNotFoundException;
use Domain\Query\GetSingleDinosaur;
use Domain\Query\GetAllDinosaurs;
use Domain\UseCase\CreateDinosaur;
use Domain\UseCase\EditDinosaur;
use Domain\UseCase\RemoveDinosaur;
use DomainException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DinosaursController extends AbstractController
{
    public function __construct(
        private CommandBus $commandBus,
        private QueryBus $queryBus
    ) {
    }

    #[Route('/dinosaurs', name: 'app_list_dinosaurs')]
    public function list(Request $request): Response
    {
        $q = null;
        $form = $this->createForm(SearchType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData();

            $q = $search['q'];
        }

        $dinosaurs = $this->queryBus->dispatch(new GetAllDinosaurs\Query($q));

        return $this->render('dinosaurs-list.html.twig', [
            'dinosaurs' => $dinosaurs,
            'searchForm' => $form->createView(),
        ]);
    }

    #[Route(
        '/dinosaurs/{id}',
        name: 'app_single_dinosaur',
        requirements: ['id' => '\d+']
    )]
    public function single(string $id): Response
    {
        $dinosaur = $this
            ->dinosaursCollection
            ->find($id);

        if (false === $dinosaur) {
            throw $this->createNotFoundException('The dinosaur you are looking for does not exists.');
        }

        return $this->render('dinosaur.html.twig', [
            'dinosaur' => $dinosaur,
        ]);
    }

    #[Route('/dinosaurs/create', name: 'app_create_dinosaur')]
    public function create(Request $request): Response
    {
        $form = $this->createForm(DinosaurType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dinosaur = $form->getData();

            $input = new CreateDinosaur\Input(
                $dinosaur['name'],
                $dinosaur['gender'],
                $dinosaur['species']->getId(),
                $dinosaur['age'],
                $dinosaur['eyesColor']
            );

            try {
                $this->commandBus->dispatch($input);

                $this->addFlash('success', 'The dinosaur has been created!');

                return $this->redirectToRoute('app_list_dinosaurs');
            } catch (DomainException $e) {
                $this->addFlash('danger', $e->getMessage());
            }
        }

        return $this->render('create-dinosaur.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route(
        '/dinosaurs/{id}/edit',
        name: 'app_edit_dinosaur',
        requirements: ['id' => '\d+']
    )]
    public function edit(Request $request, int $id): Response
    {
        try {
            $dinosaur = $this->queryBus->dispatch(new GetSingleDinosaur\Query($id));
        } catch (DinosaurNotFoundException $e) {
            throw $this->createNotFoundException(
                'The dinosaur you are looking for does not exists.'
            );
        }

        $form = $this->createForm(DinosaurType::class, $dinosaur);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dinosaur = $form->getData();

            $input = EditDinosaur\Input::fromReadModel($dinosaur);

            try {
                $this->commandBus->dispatch($input);

                $this->addFlash('success', 'The dinosaur has been updated!');

                return $this->redirectToRoute('app_list_dinosaurs');
            } catch (DomainException $e) {
                $this->addFlash('danger', $e->getMessage());
            }
        }

        return $this->render('edit-dinosaur.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route(
        '/dinosaurs/{id}/remove',
        name: 'app_remove_dinosaur',
        requirements: ['id' => '\d+']
    )]
    public function remove(int $id): Response
    {
        $input = new RemoveDinosaur\Input($id);

        try {
            $this->commandBus->dispatch($input);

            $this->addFlash('success', 'The dinosaur has been removed!');
        } catch (DomainException $e) {
            $this->addFlash('danger', $e->getMessage());
        }

        return $this->redirectToRoute('app_list_dinosaurs');
    }
}
