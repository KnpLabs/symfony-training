<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FeedingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options['feeding'] === 'Carnivore') {
            $choices = ['Carnivore' => 'Carnivore'];
        } else if ($options['feeding'] === 'Herbivore' || $options['feeding'] === 'Omnivore') {
            $choices = [
                'Herbivore' => 'Herbivore',
                'Omnivore' => 'Omnivore'
            ];
        } else {
            $choices = [
                'Carnivore' => 'Carnivore',
                'Herbivore' => 'Herbivore',
                'Omnivore' => 'Omnivore'
            ];
        }

        $builder
            ->add('feeding', ChoiceType::class, [
                'label' => false,
                'choices' => $choices,
                'multiple' => $options['can_be_multiple'],
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'feeding' => null,
            'can_be_multiple' => true,
        ]);

        $resolver->setAllowedTypes('feeding', ['null', 'string']);
        $resolver->setAllowedTypes('can_be_multiple', ['bool']);
    }
}