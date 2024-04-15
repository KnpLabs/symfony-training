<?php

namespace App\DataFixtures;

use App\Entity\Dinosaur;
use App\Entity\Species;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class AppFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        /**
         * Create a user with the role ROLE_ADMIN.
         */
        $admin = new User(
            'admin@mail.com',
            ['ROLE_ADMIN']
        );

        $hashedPassword = $this->passwordHasher->hashPassword($admin, 'admin');
        $admin->setHashedPassword($hashedPassword);

        $manager->persist($admin);

        /*
         * Create basic users with the default role ROLE_USER
         */
        for ($i = 0; $i < 10; ++$i) {
            $user = new User(
                'user_' . $i . '@mail.com'
            );

            $hashedPassword = $this->passwordHasher->hashPassword($user, 'password');
            $user->setHashedPassword($hashedPassword);

            $manager->persist($user);
        }

        $manager->flush();

        /**
         * Create species.
         */
        $species = [
            [
                'name' => 'Tyrannosaurus rex',
                'habitats' => ['Forest'],
                'feeding' => 'Carnivore',
            ],
            [
                'name' => 'Velociraptor',
                'habitats' => ['Air', 'Forest'],
                'feeding' => 'Carnivore',
            ],
            [
                'name' => 'Triceratops',
                'habitats' => ['Forest'],
                'feeding' => 'Herbivore',
            ],
            [
                'name' => 'Stegosaurus',
                'habitats' => ['Forest'],
                'feeding' => 'Herbivore',
            ],
            [
                'name' => 'Brachiosaurus',
                'habitats' => ['Forest'],
                'feeding' => 'Herbivore',
            ],
            [
                'name' => 'Allosaurus',
                'habitats' => ['Forest'],
                'feeding' => 'Carnivore',
            ],
            [
                'name' => 'Pteranodon',
                'habitats' => ['Sea', 'Air'],
                'feeding' => 'Carnivore',
            ],
            [
                'name' => 'Diplodocus',
                'habitats' => ['Forest'],
                'feeding' => 'Herbivore',
            ],
            [
                'name' => 'Parasaurolophus',
                'habitats' => ['Forest', 'Desert'],
                'feeding' => 'Herbivore',
            ],
            [
                'name' => 'Spinosaurus',
                'habitats' => ['Forest', 'Sea'],
                'feeding' => 'Carnivore',
            ],
        ];

        foreach ($species as $specie) {
            $specie = new Species(
                $specie['name'],
                $specie['habitats'],
                $specie['feeding'],
            );

            $manager->persist($specie);
        }

        $manager->flush();

        /**
         * Create dinosaurs.
         */
        $speciesList = $manager
            ->getRepository(Species::class)
            ->findAll();

        $gender = [
            'Male',
            'Female',
        ];

        for ($i = 0; $i < 15; ++$i) {
            $dinosaur = new Dinosaur(
                'dinosaur_' . $i,
                $gender[array_rand($gender)],
                $speciesList[array_rand($speciesList)],
                rand(1, 40),
                '#000000'
            );

            $manager->persist($dinosaur);
        }

        $manager->flush();
    }
}
