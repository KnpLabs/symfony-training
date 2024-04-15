<?php

namespace App\Form\Type;

use App\Entity\Species;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class SpeciesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('habitats', ChoiceType::class, [
                'choices' => [
                    'Forest' => 'Forest',
                    'Sea' => 'Sea',
                    'Desert' => 'Desert',
                    'Air' => 'Air',
                ],
                'multiple' => true,
            ])
            ->add('feeding', ChoiceType::class, [
                'choices' => [
                    'Carnivore' => 'Carnivore',
                    'Herbivore' => 'Herbivore',
                    'Omnivore' => 'Omnivore',
                ],
            ])
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Species::class,
            'empty_data' => function (FormInterface $form) {
                return new Species(
                    $form->get('name')->getData(),
                    $form->get('habitats')->getData(),
                    $form->get('feeding')->getData(),
                );
            },
        ]);
    }
}
