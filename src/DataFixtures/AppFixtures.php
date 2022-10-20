<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Dinosaur;
use App\Entity\User;
use App\Entity\Species;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        /**
         * Create a user with the role ROLE_ADMIN
         */
        $admin = new User(
            'admin@mail.com',
            ['ROLE_ADMIN']
        );

        $hashedPassword = $this->passwordHasher->hashPassword($admin, 'admin');
        $admin->setHashedPassword($hashedPassword);

        $manager->persist($admin);

        /**
         * Create basik users with the default role ROLE_USER
         */
        for ($i = 0; $i < 10; $i++) {
            $user = new User(
                'user_' . $i . '@mail.com'
            );

            $hashedPassword = $this->passwordHasher->hashPassword($user, 'password');
            $user->setHashedPassword($hashedPassword);

            $manager->persist($user);
        }

        $manager->flush();

        /**
         * Create species
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
         * Create dinosaurs
         */
        $speciesList = $manager
            ->getRepository(Species::class)
            ->findAll()
        ;

        $gender = [
            'Male',
            'Female'
        ];

        for ($i = 0; $i < 15; $i++) {
            $dinosaur = new Dinosaur(
                'dinosaur_' . $i,
                $gender[array_rand($gender)],
                $speciesList[array_rand($speciesList)],
                rand(1, 40),
                "#000000"
            );

            $manager->persist($dinosaur);
        }

        $manager->flush();

        /**
         * Create categories
         */
        $prices = [
            new Category('Full price', 126),
            new Category('Student', 105),
            new Category('Senior', 109.5),
            new Category('Child (under 12)', 84),
            new Category('Toddler (under 3)', 0),
        ];

        foreach ($prices as $price) {
            $manager->persist($price);
        }

        $manager->flush();
    }
}
