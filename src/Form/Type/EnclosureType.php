<?php

namespace App\Form\Type;

use App\Entity\Enclosure;
use App\Form\Type\FeedingType;
use App\Form\Type\HabitatType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EnclosureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $species = $options['dinosaur'] ? $options['dinosaur']->getSpecies() : null;
        $habitats = $species ? $species->getHabitats() : null;
        $feeding = $species ? $species->getFeeding() : null;

        $builder
            ->add('name', TextType::class)
        ;

        if ($feeding === 'Carnivore' && !in_array('Air', $habitats)) {
            $builder
                ->add('fences', ChoiceType::class, [
                    'choices' => [
                        'Electric Fence' => 'electric_fence'
                    ],
                ])
            ;
        } else if ($habitats && in_array('Air', $habitats)) {
            $builder
                ->add('fences', ChoiceType::class, [
                    'choices' => [
                        'Aviary' => 'aviary',
                    ],
                ])
            ;
        } else {
            $builder
                ->add('fences', ChoiceType::class, [
                    'choices' => [
                        'Standard Fence' => 'standard_fence',
                        'Electric Fence' => 'electric_fence',
                        'No Fence' => 'no_fence',
                        'Aviary' => 'aviary'
                    ],
                ])
            ;
        }

        $builder
            ->add('habitats', HabitatType::class, [
                'habitats' => $habitats,
            ])
            ->add('feeding', FeedingType::class, [
                'feeding' => $feeding,
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Enclosure::class,
            'empty_data' => function (FormInterface $form) {
                return new Enclosure(
                    $form->get('name')->getData(),
                    $form->get('fences')->getData(),
                    $form->get('habitat')->getData(),
                    $form->get('feeding')->getData(),
                    $form->get('maxDinosaurs')->getData(),
                );
            },
            'dinosaur' => null,
        ]);

        $resolver->setAllowedTypes('dinosaur', ['null', 'App\Entity\Dinosaur']);
    }
}