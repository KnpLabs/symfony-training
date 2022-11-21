<?php

namespace App\Controller;

use App\Entity\Dinosaur;
use App\Form\Type\DinosaurType;
use App\Form\Type\SearchType;
use App\Message\CreateDinosaur;
use App\Message\DeleteDinosaur;
use App\Message\EditDinosaur;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

final class DinosaursController extends AbstractController
{
    public function __construct(private MessageBusInterface $bus)
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
            ->search($q);

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
    public function single(string $id, ManagerRegistry $doctrine): Response
    {
        $dinosaur = $doctrine
            ->getRepository(Dinosaur::class)
            ->find($id);

        if (false === $dinosaur) {
            throw $this->createNotFoundException('The dinosaur you are looking for does not exists.');
        }

        return $this->render('dinosaur.html.twig', [
            'dinosaur' => $dinosaur,
        ]);
    }

    #[Route('/dinosaurs/create', name: 'app_create_dinosaur')]
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(DinosaurType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $this->bus->dispatch(new CreateDinosaur(
                name: $data->getName(),
                gender: $data->getGender(),
                eyesColor: $data->getEyesColor(),
                age: $data->getAge(),
                speciesId: $data->getSpecies()->getId()
            ));

            $this->addFlash('success', 'The dinosaur has been created!');

            return $this->redirectToRoute('app_list_dinosaurs');
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
    public function edit(Request $request, int $id, ManagerRegistry $doctrine): Response
    {
        $dinosaur = $doctrine
            ->getRepository(Dinosaur::class)
            ->find($id);

        if (false === $dinosaur) {
            throw $this->createNotFoundException('The dinosaur you are looking for does not exists.');
        }

        $form = $this->createForm(DinosaurType::class, $dinosaur);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $this->bus->dispatch(new EditDinosaur(
                id: $id,
                name: $data->getName(),
                gender: $data->getGender(),
                eyesColor: $data->getEyesColor(),
                age: $data->getAge(),
                speciesId: $data->getSpecies()->getId()
            ));

            $this->addFlash('success', 'The dinosaur has been edited!');

            return $this->redirectToRoute('app_list_dinosaurs');
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
        $this->bus->dispatch(new DeleteDinosaur($id));

        $this->addFlash('success', 'The dinosaur has been removed!');

        return $this->redirectToRoute('app_list_dinosaurs');
    }
}
