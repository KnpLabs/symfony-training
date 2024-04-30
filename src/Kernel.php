<?php

declare(strict_types=1);

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public const CONFIG_EXTS = '.{php,xml,yaml,yml}';

    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader): void
    {
        $confDir = "{$this->getProjectDir()}/config";
        $container->addResource(new FileResource("{$confDir}/bundles.php"));

        $loader->load("{$confDir}/{packages}/*".self::CONFIG_EXTS, 'glob');
        $loader->load("{$confDir}/{packages}/{$this->environment}/**/*".self::CONFIG_EXTS, 'glob');

        $loader->load("{$confDir}/{services}".self::CONFIG_EXTS, 'glob');
        $loader->load("{$confDir}/{services}/**/*".self::CONFIG_EXTS, 'glob');
    }
}
