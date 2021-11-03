<?php

namespace App\Controller;

use App\Database\PdoProvider;
use App\Entity\Dinosaur;
use App\Form\Type\DinosaurType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DinosaursController extends AbstractController
{
    public function __construct(
        private PdoProvider $pdoProvider
    ) { }

    public function list(): Response
    {
        $dinosaurs = $this
            ->pdoProvider
            ->getPdo()
            ->query('SELECT * FROM dinosaur')
            ->fetchAll()
        ;

        return $this->render('dinosaurs-list.html.twig', [
            'dinosaurs' => $dinosaurs
        ]);
    }

    public function single(string $id): Response
    {
        $pdo = $this->pdoProvider->getPdo();

        $statement = $pdo->prepare('SELECT * FROM dinosaur WHERE dinosaur.id = :id');
        $statement->bindParam(':id', $id);
        $statement->execute();

        $dinosaur = $statement->fetch();

        if ($dinosaur === false) {
            throw $this->createNotFoundException(
                'The dinosaur you are looking for does not exists.'
            );
        }

        return $this->render('dinosaur.html.twig', [
            'dinosaur' => $dinosaur
        ]);
    }

    public function create(Request $request): Response
    {
        $form = $this->createForm(DinosaurType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dinosaur = $form->getData();

            $statement = $this
                ->pdoProvider
                ->getPdo()
                ->prepare("
                    INSERT INTO dinosaur (name, gender, age, species)
                    VALUES (:name, :gender, :age, :species)
                ")
            ;

            $statement->execute([
              ':name' => $dinosaur->getName(),
              ':gender' => $dinosaur->getGender(),
              ':age' => $dinosaur->getAge(),
              ':species' => $dinosaur->getSpecies(),
            ]);

            $this->addFlash('success', 'The dinosaur has been created!');

            return $this->redirectToRoute('app_list_dinosaurs');
        }

        return $this->renderForm('create-dinosaur.html.twig', [
          'form' => $form
        ]);
    }

    public function edit(Request $request, int $id): Response
    {
        $pdo = $this->pdoProvider->getPdo();

        $statement = $pdo->prepare('SELECT * FROM dinosaur WHERE dinosaur.id = :id');
        $statement->bindParam(':id', $id);
        $statement->execute();

        $dinosaurData = $statement->fetch();

        if ($dinosaurData === false) {
            throw $this->createNotFoundException(
                'The dinosaur you are looking for does not exists.'
            );
        }

        $dinosaur = new Dinosaur(
            $dinosaurData['name'],
            $dinosaurData['gender'],
            $dinosaurData['species'],
            $dinosaurData['age']
        );

        $form = $this->createForm(DinosaurType::class, $dinosaur);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dinosaur = $form->getData();

            $statement = $this
                ->pdoProvider
                ->getPdo()
                ->prepare("
                    UPDATE dinosaur 
                    SET name = :age, gender = :gender, age = :age, species = :species
                    WHERE id = :id
                ")
            ;

            $statement->execute([
              ':id' => $id,
              ':name' => $dinosaur->getName(),
              ':gender' => $dinosaur->getGender(),
              ':age' => $dinosaur->getAge(),
              ':species' => $dinosaur->getSpecies(),
            ]);

            $this->addFlash('success', 'The dinosaur has been edited!');

            return $this->redirectToRoute('app_list_dinosaurs');
        }

        return $this->renderForm('edit-dinosaur.html.twig', [
          'form' => $form
        ]);
    }
}
