<?php

namespace App\Form\Type;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use App\Form\DataTransformer\MoneyTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CategoryType extends AbstractType
{
    public function __construct(
        MoneyTransformer $moneyTransformer
    ) {
        $this->moneyTransformer = $moneyTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('price', NumberType::class)
            ->add('submit', SubmitType::class)
        ;

        $builder->get('price')
            ->addModelTransformer($this->moneyTransformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
            'empty_data' => function (FormInterface $form) {
                return new Category(
                    $form->get('name')->getData(),
                    $form->get('price')->getData()
                );
            }
        ]);
    }
}
