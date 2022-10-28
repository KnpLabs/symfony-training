<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class FeedingType extends AbstractType
{
    public function getParent()
    {
        return ChoiceType::class;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'feeding' => null,
            'can_be_multiple' => true,
            'expanded' => true,
        ]);

        $resolver->setAllowedTypes('feeding', ['null', 'string']);
        $resolver->setAllowedTypes('can_be_multiple', ['bool']);

        $resolver->setDefault('choices', function (Options $options) {
            if ($options['feeding'] === 'Carnivore') {
                return ['Carnivore' => 'Carnivore'];
            } else if ($options['feeding'] === 'Herbivore' || $options['feeding'] === 'Omnivore') {
                return [
                    'Herbivore' => 'Herbivore',
                    'Omnivore' => 'Omnivore'
                ];
            } else {
                return [
                    'Carnivore' => 'Carnivore',
                    'Herbivore' => 'Herbivore',
                    'Omnivore' => 'Omnivore'
                ];
            }
        });

        $resolver->setDefault('multiple', function (Options $options) {
            return $options['can_be_multiple'];
        });
    }
}