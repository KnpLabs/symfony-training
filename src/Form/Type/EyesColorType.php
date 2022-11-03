<?php

namespace App\Form\Type;

use Traversable;
use App\Entity\EyesColor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Exception\UnexpectedTypeException;

class EyesColorType extends AbstractType implements DataMapperInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('eyesColor', ColorType::class, [
                'label' => false,
            ])
            ->setDataMapper($this)
        ;
    }

    public function mapDataToForms($viewData, Traversable $forms): void
    {
        if (null === $viewData) {
            return;
        }

        if (!$viewData instanceof EyesColor) {
            throw new UnexpectedTypeException($viewData, EyesColor::class);
        }

        /** @var FormInterface[] $forms */
        $forms = iterator_to_array($forms);

        $r = $viewData->getRed();
        $g = $viewData->getGreen();
        $b = $viewData->getBlue();

        $forms['eyesColor']->setData(sprintf("#%02x%02x%02x", $r, $g, $b));
    }

    public function mapFormsToData(Traversable $forms, &$viewData): void
    {
        /** @var FormInterface[] $forms */
        $forms = iterator_to_array($forms);

        list($r, $g, $b) = sscanf($forms['eyesColor']->getData(), "#%02x%02x%02x");

        $viewData = new EyesColor($r, $g, $b);
    }
}