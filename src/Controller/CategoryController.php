<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\Type\CategoryType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    #[Route('/categories', name: 'app_list_categories')]
    public function list(ManagerRegistry $doctrine): Response
    {
        $categoriesList = $doctrine
            ->getRepository(Category::class)
            ->findAll()
        ;

        return $this->render('categories-list.html.twig', [
            'categoriesList' => $categoriesList
        ]);
    }

    #[Route('/category/create', name: 'app_create_category')]
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(CategoryType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $category = $form->getData();

            $em->persist($category);
            $em->flush();

            $this->addFlash('success', 'The category has been created!');

            return $this->redirectToRoute('app_list_categories');
        }

        return $this->renderForm('create-species.html.twig', [
            'form' =>  $form
        ]);
    }

    #[Route(
        '/categories/{id}/edit',
        name: 'app_edit_category',
        requirements: ['id' => '\d+']
    )]
    public function edit(Request $request, int $id, ManagerRegistry $doctrine): Response
    {
        $category = $doctrine
            ->getRepository(Category::class)
            ->find($id)
        ;

        if ($category === false) {
            throw $this->createNotFoundException(
                'The category you are looking for does not exists.'
            );
        }

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $category = $form->getData();

            $em->flush();

            $this->addFlash('success', 'The category has been edited!');

            return $this->redirectToRoute('app_list_categories');
        }

        return $this->renderForm('edit-category.html.twig', [
            'form' => $form,
        ]);
    }
}