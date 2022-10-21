<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HabitatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
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

        $builder
            ->add('habitats', ChoiceType::class, [
                'label' => false,
                'choices' => $choices,
                'multiple' => true,
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'habitats' => null,
        ]);

        $resolver->setAllowedTypes('habitats', ['null', 'array']);
    }
}