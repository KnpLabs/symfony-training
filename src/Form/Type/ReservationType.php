<?php

namespace App\Form\Type;

use App\Entity\User;
use App\Entity\Reservation;
use App\Form\Type\TicketType;
use App\Validator\ContainsAdult;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Validator\Constraints\NotBlank;

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
                        'value' => 'today - 1 day',
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
                    new ContainsAdult(),
                ],
                'help' => 'Children must be accompanied by an adult.',
            ])
            ->add('submit', SubmitType::class)
        ;

        $builder->get('tickets')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $tickets = $event->getForm()->getData();
                $form = $event->getForm()->getParent();

                if ($tickets) {
                    $choices = [];
                    $totalPrice = 0;
                    foreach ($tickets as $ticket) {
                        $totalPrice += $ticket->getCategory()->getPrice();
                    }

                    if ($totalPrice >= 105 && $totalPrice <= 252) {
                        $choices = [
                            'Poster of the T-Rex' => 'poster',
                            'Dessert at the park\'s restaurant' => 'dessert',
                            'Key ring of the park' => 'key_ring',
                            'Mug of the park' => 'mug',
                        ];
                    } else if ($totalPrice > 252 && $totalPrice <= 500) {
                        $choices = [
                            'Portrait in the Valley of Diplodocus' => 'portrait',
                            'Meal at the park\'s restaurant' => 'meal',
                            'Access to the meal of the Parasaurolophus event' => 'event_p_meal',
                            'T-shirt of the park' => 't-shirt',
                        ];
                    } else {
                        $choices = [
                            'Night at the park\'s hotel' => 'hotel',
                            'Access to the meal of the T-Rex event (adults only)' => 'event_t_meal',
                            'VIP car ride inside the Valley of Diplodocus' => 'car_ride',
                            'Bag of goodies' => 'goodies',
                        ];
                    }

                    $form->add('gift', ChoiceType::class, [
                        'choices' => $choices,
                        'expanded' => false,
                        'multiple' => false,
                        'required' => true,
                        'placeholder' => 'Choose an option',
                        'constraints' => [
                            new NotBlank([
                                'message' => '',
                            ]),
                        ],
                        'help' => 'Thank you for your future visit! You can choose one gift. It will be given to you at your arrival at the park.',
                    ]);
                }
            }
        );
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