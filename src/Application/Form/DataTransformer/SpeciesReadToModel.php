<?php

declare(strict_types=1);

namespace Application\Form\DataTransformer;

use Domain\Collection\SpeciesCollection;
use Domain\Exception\SpeciesNotFoundException;
use Domain\Model\Species as ModelSpecies;
use Domain\ReadModel\Species;
use Symfony\Component\Form\DataTransformerInterface;

class SpeciesReadToModel implements DataTransformerInterface
{
    public function __construct(
        private SpeciesCollection $speciesCollection
    ) {
    }

    public function transform(mixed $value)
    {
        if (!$value instanceof Species) {
            return $value;
        }

        $speciesId = (string) $value->getId();

        $species = $this->speciesCollection->find($speciesId);

        if ($species === null) {
            throw new SpeciesNotFoundException($speciesId);
        }

        return $species;
    }

    public function reverseTransform(mixed $value)
    {
        if (!$value instanceof ModelSpecies) {
            return $value;
        }

        return new Species($value);
    }
}
