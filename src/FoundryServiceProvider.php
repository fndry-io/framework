<?php

namespace Foundry;

use Foundry\Providers\ConsoleServiceProvider;
use Illuminate\Support\ServiceProvider;

abstract class FoundryServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Booting the package.
     */
    public function boot()
    {
    }

    /**
     * Register all modules.
     */
    public function register()
    {
    }

    /**
     * Register package's namespaces.
     */
    protected function registerNamespaces()
    {
        $configPath = __DIR__ . '/../config/config.php';

        $this->mergeConfigFrom($configPath, 'modules');
        $this->publishes([
            $configPath => config_path('modules.php'),
        ], 'config');
    }

    /**
     * Register the service provider.
     */
   protected function registerServices()
   {

   }

    /**
     * Get the services provided by the provider.
     *
     */
    public function provides()
    {

    }

    /**
     * Register providers.
     */
    protected function registerProviders()
    {
        $this->app->register(ConsoleServiceProvider::class);
    }
}
