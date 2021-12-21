<?php

namespace Timedoor\Filter;

use Illuminate\Support\ServiceProvider;
use Timedoor\Filter\Console\MakeNewFilterCommand;

class FilterServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/filter.php', 'filter');

        // Register the service the package provides.
        $this->app->singleton(Filter::class);
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/filter.php' => config_path('filter.php'),
        ], 'filter.config');
        
        // Registering package commands.
        $this->commands([
            MakeNewFilterCommand::class
        ]);
    }
}
