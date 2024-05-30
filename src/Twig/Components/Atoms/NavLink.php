<?php

declare(strict_types=1);

namespace App\Twig\Components\Atoms;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent()]
final class NavLink
{
    public string $title;
    public string $href;
    public ?bool $isActive = false;

    public function getClass(): string
    {
        return 'nav-link';
    }

    public function getAriaCurrent(): ?string
    {
        return $this->isActive ? 'page' : null;
    }
}
