<?php

namespace App\Controller;

use App\Entity\Dinosaur;
use App\Form\Type\DinosaurType;
use App\Form\Type\SearchType;
use App\Repository\DinosaurRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class DinosaursController extends AbstractController
{
    public function __construct(
        private HubInterface $hub,
        private RouterInterface $router
    ) {
    }

    #[Route('/dinosaurs', name: 'app_list_dinosaurs')]
    public function list(Request $request, ManagerRegistry $doctrine, DinosaurRepository $dinosaurRepository): Response
    {
        $q = null;
        $form = $this->createForm(SearchType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData();

            $q = $search['q'];
        }

        $dinosaurs = $dinosaurRepository->search($q);

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
    public function single(
        string $id,
        ManagerRegistry $doctrine,
        Request $request
    ): Response
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

    #[Route(
        '/api/dinosaurs/{id}',
        name: 'api_single_dinosaur',
        requirements: ['id' => '\d+']
    )]
    public function apiSingle(
        string $id,
        ManagerRegistry $doctrine,
        Request $request
    ): Response
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

        return new JsonResponse([
            'id' => $dinosaur->getId(),
            'name' => $dinosaur->getName(),
            'gender' => $dinosaur->getGender(),
            'age' => $dinosaur->getAge(),
            'eyeColor' => $dinosaur->getEyesColor(),
            'topic' => "https://dinosaur-app/api/dinosaurs/{$dinosaur->getId()}"
        ]);
    }

    #[Route('/dinosaurs/create', name: 'app_create_dinosaur')]
    public function create(
        Request $request,
        ManagerRegistry $doctrine
    ): Response
    {
        $form = $this->createForm(DinosaurType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $dinosaur = $form->getData();

            $em->persist($dinosaur);
            $em->flush();

            $update = new Update(
                [
                    'https://dinosaur-app/dinosaurs',
                    'https://dinosaur-app/activity'
                ],
                json_encode([
                    'link' => $this->router->generate('app_single_dinosaur', ['id' => $dinosaur->getId()]),
                    'name' => $dinosaur->getName(),
                    'message' => "{$dinosaur->getName()} has been created!"
                ])
            );

            $this->hub->publish($update);

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

            $update = new Update(
                [
                    sprintf('https://dinosaur-app/dinosaurs/edit/%d', $id),
                    'https://dinosaur-app/activity'
                ],
                json_encode([
                    'link' => $this->router->generate('app_single_dinosaur', ['id' => $dinosaur->getId()]),
                    'message' => "{$dinosaur->getName()} has been edited!"
                ])
            );

            $this->hub->publish($update);

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

        $update = new Update(
            [
                sprintf('https://dinosaur-app/dinosaurs/remove/%d', $id),
                'https://dinosaur-app/activity'
            ],
            json_encode([
                'link' => $this->router->generate('app_single_dinosaur', ['id' => $id]),
                'message' => "{$dinosaur->getName()} has been removed!"
            ])
        );

        $this->hub->publish($update);

        $this->addFlash('success', 'The dinosaur has been removed!');

        return $this->redirectToRoute('app_list_dinosaurs');
    }
}
