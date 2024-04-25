<?php

declare(strict_types=1);

namespace App\Validator\JsonSchema;

use Symfony\Component\HttpFoundation\Exception\BadRequestException;

final class ValidationException extends BadRequestException
{
    /**
     * @param Error[] $errors
     */
    public function __construct(
        private readonly array $errors
    ) {
        $data = [];

        foreach ($errors as $error) {
            $data[$error->getPath()] = $error->getMessage();
        }

        parent::__construct(json_encode($data, JSON_THROW_ON_ERROR));
    }
}
