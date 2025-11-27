<?php

namespace App\DataFixtures;

use App\Entity\Dinosaur;
use App\Entity\Species;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class AppFixtures extends Fixture
{
    public function __construct() {
    }

    public function load(ObjectManager $manager): void
    {
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
                'dinosaur_'.$i,
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
