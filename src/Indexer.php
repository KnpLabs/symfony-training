<?php

declare(strict_types=1);

namespace App;

use App\Entity\Dinosaur;
use Elastic\Elasticsearch\Client;

class Indexer
{
    private const INDEX_NAME = 'summary';

    public function __construct(
        private Client $client
    ) {
    }

    public function indexFromDinosaur(Dinosaur $dinosaur): void
    {
        $species = $dinosaur->getSpecies();
        $park    = $dinosaur->getPark();

        $this->client->index([
            'index' => self::INDEX_NAME,
            'type' => '_doc',
            'id' => $dinosaur->getId(),
            'body' => [
                'name' => $dinosaur->getName(),
                'age'  => $dinosaur->getAge(),
                'park_food_amount' => $park->getFoodAmount(),
                'park_name' => $park->getName(),
                'species_name' => $species->getName(),
                'habitats' => $species->getHabitats(),
                'feeding'=> $species->getFeeding(),
            ],
        ]);
    }

    public function delete(string $id)
    {
        $this->client->delete([
            'index' => self::INDEX_NAME,
            'type' => '_doc',
            'id' => $id,
        ]);
    }
}
