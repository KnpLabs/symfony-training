<?php

declare(strict_types=1);

namespace App\Twig\Components\Molecules;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class NavItem
{
    public string $title;
    public string $route;

    public function __construct(
        private readonly RouterInterface $router,
        private readonly RequestStack $requestStack,
    ) {
    }

    public function isActive(): bool
    {
        return $this->requestStack->getCurrentRequest()?->attributes->get('_route') === $this->route;
    }

    public function getAriaCurrent(): string
    {
        return $this->isActive() ? 'page' : 'false';
    }

    public function getRoutePath(): ?string
    {
        return $this->router->generate($this->route);
    }
}
