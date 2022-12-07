<?php

declare(strict_types=1);

namespace App\Validation\JsonSchema\Object\Dinosaur;

use KnpLabs\JsonSchema\JsonSchema;
use KnpLabs\JsonSchema\ObjectSchema;

class CreateSchema extends ObjectSchema
{
    public function __construct()
    {
        $this->addProperty(
            'name',
            JsonSchema::create(
                'Name',
                'Name of the dinosaur',
                ['Aladar'],
                JsonSchema::string()
            )
        );

        $this->addProperty(
            'gender',
            JsonSchema::create(
                'Gender',
                'Gender of the dinosaur',
                ['M', 'F'],
                JsonSchema::string('M|F')
            )
        );

        $this->addProperty(
            'speciesId',
            JsonSchema::create(
                'SpeciesId',
                'Species ID of the dinosaur',
                ['0', '1', '2'],
                JsonSchema::number()
            )
        );

        $this->addProperty(
            'age',
            JsonSchema::create(
                'Age',
                'Age of the dinosaur',
                [56],
                JsonSchema::positiveInteger()
            )
        );

        $this->addProperty(
            'eyesColor',
            JsonSchema::create(
                'Eyes color',
                'Eyes color of the dinosaur',
                ['brown', 'blue'],
                JsonSchema::string()
            )
        );
    }

    public function getTitle(): string
    {
        return 'Dinosaur create';
    }

    public function getDescription(): string
    {
        return 'Input data to create a dinosaur';
    }
}
