<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class GiftType extends AbstractType
{
    public function getParent()
    {
        return ChoiceType::class;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'multiple' => false,
            'expanded' => false,
            'required' => true,
            'placeholder' => 'Choose an option',
            'constraints' => [
                new NotBlank([
                    'message' => '',
                ]),
            ],
            'help' => 'Thank you for your future visit! You can choose one gift. It will be given to you at your arrival at the park.',
            'totalPrice' => 0,
        ]);

        $resolver->setAllowedTypes('totalPrice', ['int']);

        $resolver->setDefault('choices', function (Options $options) {
            if ($options['totalPrice'] >= 105 && $options['totalPrice'] <= 252) {
                return [
                    'Poster of the T-Rex' => 'poster',
                    'Dessert at the park\'s restaurant' => 'dessert',
                    'Key ring of the park' => 'key_ring',
                    'Mug of the park' => 'mug',
                ];
            } else if ($options['totalPrice'] > 252 && $options['totalPrice'] <= 500) {
                return [
                    'Portrait in the Valley of Diplodocus' => 'portrait',
                    'Meal at the park\'s restaurant' => 'meal',
                    'Access to the meal of the Parasaurolophus event' => 'event_p_meal',
                    'T-shirt of the park' => 't-shirt',
                ];
            } else {
                return [
                    'Night at the park\'s hotel' => 'hotel',
                    'Access to the meal of the T-Rex event (adults only)' => 'event_t_meal',
                    'VIP car ride inside the Valley of Diplodocus' => 'car_ride',
                    'Bag of goodies' => 'goodies',
                ];
            }
        });
    }
}