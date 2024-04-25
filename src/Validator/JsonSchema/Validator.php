<?php

declare(strict_types=1);

namespace App\Validator\JsonSchema;

use Opis\JsonSchema\Errors\ErrorFormatter;
use Opis\JsonSchema\Errors\ValidationError;
use Opis\JsonSchema\Validator as JsonSchemaValidator;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;

final readonly class Validator
{
    private const SCHEMA_PREFIX = 'http://localhost/api';

    private JsonSchemaValidator $validator;

    public function __construct(
        #[Autowire('%kernel.project_dir%/jsonSchema')]
        private string $schemaDirectoryPath
    ) {
        $this->validator = new JsonSchemaValidator();

        $this->validator->resolver()->registerPrefix(
            self::SCHEMA_PREFIX,
            $this->schemaDirectoryPath
        );

        $this->validator->setMaxErrors(10);
    }

    public function validate(Request $request, string $schemaPath): void
    {
        $data = json_decode(
            $request->getContent(),
            flags: JSON_THROW_ON_ERROR
        );

        $result = $this->validator->validate(
            $data,
            self::SCHEMA_PREFIX . $schemaPath
        );

        if ($result->isValid()) {
            return;
        }

        throw new ValidationException([...$this->yieldErrors($result->error())]);
    }

    /**
     * @return iterable<Error>
     */
    private function yieldErrors(ValidationError $error): iterable
    {
        $formatter = new ErrorFormatter();

        $errors = $formatter->format($error);

        foreach ($errors as $field => $message) {
            $formatted = sizeof($message) === 1
                ? $message[0]
                : json_encode($message);

            yield new Error(
                $field,
                $formatted,
            );
        }
    }
}
