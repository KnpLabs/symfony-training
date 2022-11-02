<?php

namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class MoneyTransformer implements DataTransformerInterface
{
    public function transform($value): string
    {
        $strNumberLength = strlen(strval($value));

        if ($strNumberLength > 2) {
            $number = substr_replace(strval($value), '.', -2, 0);
        } elseif (2 === $strNumberLength) {
            $number = substr_replace(strval($value), '0.', -2, 0);
        } elseif (1 === $strNumberLength) {
            $number = substr_replace(strval($value), '0.0', -2, 0);
        } else {
            $number = '0.00';
        }

        return floatval(number_format((float) $number, 2, '.', ' '));
    }

    public function reverseTransform($value): int
    {
        $amount = str_replace(',', '.', $value);

        if (is_numeric($amount)) {
            return intval($amount * 100);
        } else {
            throw new TransformationFailedException('Expected a numeric.');
        }
    }
}