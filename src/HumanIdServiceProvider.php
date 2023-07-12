<?php

namespace Lemaur\HumanId;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class HumanIdServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-human-id')
            ->hasConfigFile();
    }

    public function packageBooted(): void
    {
        collect(array_merge(
            (array) glob(__DIR__.'/Database/Schema/Blueprints/*.php'),
            (array) glob(__DIR__.'/Support/*.php')
        ))->each(static fn ($path) => require $path);
    }
}
