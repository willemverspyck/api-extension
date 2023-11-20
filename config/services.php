<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services
        ->defaults()
            ->autowire()
            ->autoconfigure();

    $services
        ->load('Spyck\\ApiExtension\\', sprintf('%s/../src', __DIR__))
        ->exclude([
            sprintf('%s/../src/Model/', __DIR__),
        ]);
};
