<?php

namespace App\Form\Type;

use App\Entity\Dinosaur;
use App\Entity\Species;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DinosaurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('gender', DatalistType::class, [
                'choices' => [
                    'Male',
                    'Female',
                ],
            ])
            ->add('species', EntityType::class, [
                'class' => Species::class,
                'choice_label' => 'name',
            ])
            ->add('age', NumberType::class)
            ->add('eyesColor', ColorType::class)
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Dinosaur::class,
            'empty_data' => function (FormInterface $form) {
                return new Dinosaur(
                    $form->get('name')->getData(),
                    $form->get('gender')->getData(),
                    $form->get('species')->getData(),
                    $form->get('age')->getData(),
                    $form->get('eyesColor')->getData(),
                );
            },
        ]);
    }
}
