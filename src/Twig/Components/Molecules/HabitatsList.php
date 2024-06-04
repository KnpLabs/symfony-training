<?php

declare(strict_types=1);

namespace App\Twig\Components\Molecules;

use App\Repository\HabitatRepository;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent]
final class HabitatsList
{
    public array $habitats;

    public function __construct(
        private readonly HabitatRepository $habitatRepository,
    ) {
    }

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();

        $resolver->define('habitats');
        $resolver->setAllowedTypes('habitats', 'array');
        $resolver->setRequired('habitats');

        return $resolver->resolve($data);
    }
}
