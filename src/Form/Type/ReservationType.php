<?php

namespace App\Form\Type;

use App\Entity\User;
use App\Entity\Reservation;
use App\Form\Type\TicketType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('buyer', EntityType::class, [
                'class' => User::class,
                'data' => $options['buyer'],
                'disabled' => true,
            ])
            ->add('dateOfVisit', DateType::class, [
                'widget' => 'single_text',
                'constraints' => [
                    new GreaterThan([
                        'value' => 'today',
                        'message' => 'Without a time machine, you can\'t book a ticket for the past.',
                    ]),
                ],
            ])
            ->add('tickets', CollectionType::class, [
                'entry_type' => TicketType::class,
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
                'constraints' => [
                    new Count([
                        'min' => 1,
                        'minMessage' => "You haven't added any tickets."
                    ]),
                ],
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
            'empty_data' => function (FormInterface $form) {
                return new Reservation(
                    $form->get('buyer')->getData(),
                    $form->get('dateOfVisit')->getData(),
                    $form->get('tickets')->getData(),
                );
            },
            'buyer' => null,
        ]);

        $resolver->setAllowedTypes('buyer', ['null', 'App\Entity\User']);
    }
}