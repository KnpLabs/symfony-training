<?php

namespace App\MessageHandler;

use App\Entity\Dinosaur;
use App\Entity\Species;
use App\Message\EditDinosaur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class EditDinosaurHandler implements MessageHandlerInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function __invoke(EditDinosaur $message): void
    {
        $dinosaurRepository = $this->entityManager->getRepository(Dinosaur::class);
        $speciesRepository = $this->entityManager->getRepository(Species::class);

        /** @var Dinosaur $dinosaur */
        if (!$dinosaur = $dinosaurRepository->find($message->getId())) {
            throw new NotFoundHttpException("Dinosaur with id {$message->getId()} not found");
        }

        /** @var Species $species */
        if (!$species = $speciesRepository->find($message->getSpeciesId())) {
            throw new NotFoundHttpException("Species with id {$message->getSpeciesId()} not found");
        }

        $dinosaur->setName($message->getName());
        $dinosaur->setEyesColor($message->getEyesColor());
        $dinosaur->setAge($message->getAge());
        $dinosaur->setSpecies($species);

        $this->entityManager->flush();
    }
}
