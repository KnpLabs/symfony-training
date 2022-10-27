<?php

namespace App\Validator;

use App\Validator\ContainsAdult;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ContainsAdultValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof ContainsAdult) {
            throw new UnexpectedTypeException($constraint, ContainsAdult::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        $onlyChildren = true;

        foreach ($value as $ticket) {
            if ($ticket->getCategory()->isAdult()) {
                $onlyChildren = false;
            }
        }

        if ($onlyChildren) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}