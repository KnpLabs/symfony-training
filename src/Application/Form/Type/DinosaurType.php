<?php

namespace Application\Form\Type;

use Application\Form\DataTransformer\SpeciesReadToModel;
use Domain\Model\Species;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class DinosaurType extends AbstractType
{
    public function __construct(
        private SpeciesReadToModel $speciesReadToModel
    ) {
    }

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
            ->add('submit', SubmitType::class);

        $builder->get('species')->addModelTransformer($this->speciesReadToModel);
    }
}
