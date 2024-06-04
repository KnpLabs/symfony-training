<?php

namespace App\DataFixtures;

use App\Entity\Dinosaur;
use App\Entity\Habitat;
use App\Entity\Species;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
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
         * Create habitats.
         */
        $forest = new Habitat(
            'Forest',
            'A forest is a large area dominated by trees. Hundreds of more precise definitions of forest are used throughout the world, incorporating factors such as tree density, tree height, land use, legal standing, and ecological function.'
        );

        $manager->persist($forest);

        $desert = new Habitat(
            'Desert',
            'A desert is a barren area of landscape where little precipitation occurs and, consequently, living conditions are hostile for plant and animal life.'
        );

        $manager->persist($desert);

        $sea = new Habitat(
            'Sea',
            'The sea is the interconnected system of all the Earth\'s oceanic waters, including the Atlantic, Pacific, Indian, Southern, and Arctic Oceans.'
        );

        $manager->persist($sea);

        $air = new Habitat(
            'Air',
            'Air is the Earth\'s atmosphere. Air around us is a mixture of many gases and dust particles.'
        );

        $manager->persist($air);


        /**
         * Create species.
         */
        $species = [
            [
                'name' => 'Tyrannosaurus rex',
                'habitats' => new ArrayCollection([$forest]),
                'feeding' => 'Carnivore',
            ],
            [
                'name' => 'Velociraptor',
                'habitats' => new ArrayCollection([$air, $forest]),
                'feeding' => 'Carnivore',
            ],
            [
                'name' => 'Triceratops',
                'habitats' => new ArrayCollection([$forest]),
                'feeding' => 'Herbivore',
            ],
            [
                'name' => 'Stegosaurus',
                'habitats' => new ArrayCollection([$forest]),
                'feeding' => 'Herbivore',
            ],
            [
                'name' => 'Brachiosaurus',
                'habitats' => new ArrayCollection([$forest]),
                'feeding' => 'Herbivore',
            ],
            [
                'name' => 'Allosaurus',
                'habitats' => new ArrayCollection([$forest]),
                'feeding' => 'Carnivore',
            ],
            [
                'name' => 'Pteranodon',
                'habitats' => new ArrayCollection([$sea, $air]),
                'feeding' => 'Carnivore',
            ],
            [
                'name' => 'Diplodocus',
                'habitats' => new ArrayCollection([$forest]),
                'feeding' => 'Herbivore',
            ],
            [
                'name' => 'Parasaurolophus',
                'habitats' => new ArrayCollection([$forest, $desert]),
                'feeding' => 'Herbivore',
            ],
            [
                'name' => 'Spinosaurus',
                'habitats' => new ArrayCollection([$forest, $sea]),
                'feeding' => 'Carnivore',
            ],
        ];

        foreach ($species as $specie) {
            $specie = new Species(
                $specie['name'],
                $specie['feeding'],
                $specie['habitats']
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
