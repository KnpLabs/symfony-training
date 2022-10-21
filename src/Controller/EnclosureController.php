<?php

namespace App\Controller;

use App\Entity\Dinosaur;
use App\Form\Type\EnclosureType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EnclosureController extends AbstractController
{
    #[Route(
        '/dinosaurs/{id}/enclosure/create',
        name: 'app_create_enclosure',
        requirements: ['id' => '\d+']
    )]
    public function create(string $id, Request $request, ManagerRegistry $doctrine): Response
    {
        $dinosaur = $doctrine
            ->getRepository(Dinosaur::class)
            ->find($id)
        ;

        $form = $this->createForm(EnclosureType::class, null, ['dinosaur' => $dinosaur]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $enclosure = $form->getData();

            $em->persist($enclosure);
            $em->flush();

            $this->addFlash('success', 'Your enclosure is saved!');

            return $this->redirectToRoute('app_list_dinosaurs');
        }

        return $this->renderForm('create-enclosure.html.twig', [
            'form' =>  $form
        ]);
    }
}