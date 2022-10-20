<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\Type\ReservationType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReservationController extends AbstractController
{
    #[Route('/reservation/create', name: 'app_create_reservation')]
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(ReservationType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $reservation = $form->getData();

            $em->persist($reservation);
            $em->flush();

            $this->addFlash('success', 'Your reservation is saved!');

            return $this->redirectToRoute('app_list_reservations');
        }

        return $this->renderForm('create-reservation.html.twig', [
            'form' =>  $form
        ]);
    }

    #[Route('/reservations', name: 'app_list_reservations')]
    public function list(ManagerRegistry $doctrine): Response
    {
        $reservationsList = $doctrine
            ->getRepository(Reservation::class)
            ->findByBuyer($this->getUser())
        ;

        return $this->render('reservations-list.html.twig', [
            'reservationsList' => $reservationsList
        ]);
    }
}