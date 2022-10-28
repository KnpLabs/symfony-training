<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class HabitatType extends AbstractType
{
    public function getParent()
    {
        return ChoiceType::class;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'habitats' => null,
            'multiple' => true,
            'expanded' => true,
        ]);

        $resolver->setAllowedTypes('habitats', ['null', 'array']);

        $resolver->setDefault('choices', function (Options $options) {
            if ($options['habitats']) {
                $choices = [];
                foreach ($options['habitats'] as $habitat) {
                    $choices[$habitat] = $habitat;
                }
            } else {
                $choices = [
                    'Forest' => 'Forest',
                    'Sea' => 'Sea',
                    'Desert' => 'Desert',
                    'Air' => 'Air'
                ];
            }

            return $choices;
        });
    }
}