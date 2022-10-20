<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FeedingType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'choices' => [
                'Carnivore' => 'Carnivore',
                'Herbivore' => 'Herbivore',
                'Omnivore' => 'Omnivore'
            ],
        ]);
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }
}