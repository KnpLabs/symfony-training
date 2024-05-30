<?php

declare(strict_types=1);

namespace App\Twig\Components\Atoms;

use App\Entity\Habitat;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent]
final class HabitatsListItem
{
    public Habitat $habitat;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();

        $resolver->define('habitat');
        $resolver->setAllowedTypes('habitat', Habitat::class);
        $resolver->setRequired('habitat');

        return $resolver->resolve($data);
    }
}
