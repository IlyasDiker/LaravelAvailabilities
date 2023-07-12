<?php

namespace Ilyasdiker\LaravelAvailabilities;

use Illuminate\Support\ServiceProvider;

class LaravelAvailabilitiesServiceProvider extends ServiceProvider
{
    function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }

    function register(): void
    {

    }
}
