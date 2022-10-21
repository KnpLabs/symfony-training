<?php

namespace App\Form\Type;

use App\Entity\Species;
use App\Form\Type\FeedingType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SpeciesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('habitats', HabitatType::class)
            ->add('feeding', FeedingType::class, [
                'can_be_multiple' => false,
            ])
            ->add('submit', SubmitType::class)
        ;
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
            }
        ]);
    }
}