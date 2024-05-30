<?php

namespace App\Twig\Extensions;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class DinosaurExtension extends AbstractExtension
{
    /**
     * {@inheritDoc}
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('adultOnly', [DinosaurRuntime::class, 'onlyAdult']),
        ];
    }
}
