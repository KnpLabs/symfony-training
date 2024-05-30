<?php

declare(strict_types=1);

namespace App\Twig\Components\Atoms;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent()]
final class NavLink
{
    public string $href;
    public ?bool $isActive;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();

        $resolver->define('isActive');
        $resolver->define('href');
        $resolver->setAllowedTypes('isActive', 'bool');
        $resolver->setAllowedTypes('href', 'string');
        $resolver->setRequired('href');
        $resolver->setDefault('isActive', false);

        return $resolver->resolve($data);
    }

    public function getClass(): string
    {
        return 'nav-link';
    }

    public function getAriaCurrent(): ?string
    {
        return $this->isActive ? 'page' : null;
    }
}
