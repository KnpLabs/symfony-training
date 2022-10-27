<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

class ContainsAdult extends Constraint
{
    public $message = 'Children must be accompanied by an adult. You must have at least one adult ticket.';

    public function __construct($options = null)
    {
        parent::__construct($options);
    }
}