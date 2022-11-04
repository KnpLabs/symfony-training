<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Traversable;

class UserType extends AbstractType implements DataMapperInterface
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class)
            ->add('submit', SubmitType::class, [
                'label' => 'Register'
            ])
            ->setDataMapper($this)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'empty_data' => function (FormInterface $form) {
                return new User(
                    $form->get('email')->getData(),
                );
            }
        ]);
    }

    public function mapDataToForms($viewData, Traversable $forms)
    {
        if (null === $viewData) {
            return;
        }
    }

    public function mapFormsToData(Traversable $forms, &$viewData)
    {
        $forms = iterator_to_array($forms);

        $viewData = new User(
            $forms['email']->getData(),
        );

        $hashedPassword = $this->passwordHasher->hashPassword($viewData, $forms['password']->getData());

        $viewData->setHashedPassword($hashedPassword);
    }
}
