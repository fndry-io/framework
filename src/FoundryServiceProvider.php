<?php

namespace Foundry;

use Foundry\Config\SettingRepository;
use Foundry\Contracts\Repository;
use Foundry\Models\Setting;
use Foundry\Providers\ConsoleServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class FoundryServiceProvider extends ServiceProvider
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
        $this->registerNamespaces();
        $this->registerEvents();

        if ($this->app->runningInConsole()) {
            $this->registerMigrations();

            $this->publishes([
                __DIR__.'/../database/migrations' => database_path('migrations'),
            ], 'foundry-migrations');
        }
    }

    /**
     * Register all modules.
     */
    public function register()
    {
        $this->registerServices();
        $this->registerProviders();
    }

    /**
     * Register package's namespaces.
     */
    protected function registerNamespaces()
    {
        $moduleConfigPath = __DIR__ . '/../config/modules.php';
        $configPath = __DIR__ . '/../config/config.php';

        $this->mergeConfigFrom($moduleConfigPath, 'modules');
        $this->mergeConfigFrom($configPath, 'foundry');

        $this->publishes([
            $moduleConfigPath => config_path('modules.php'),
            $configPath => config_path('foundry.php')
        ], 'config');

    }

    /**
     * Register the service provider.
     */
   protected function registerServices()
   {

       $this->app->singleton(Repository::class, function () {

           $settings = $this->getSettingsItems();

           return new SettingRepository($settings);
       });

       $this->app->alias(Repository::class, 'settings');

   }

    /**
     * Get the services provided by the provider.
     *
     */
    public function provides() : void
    {

    }

    /**
     * Get all settings values
     *
     * @return array
     */
    private function getSettingsItems(): array
    {

        $table = SettingRepository::getTable();

        $settings = DB::table($table)->get();

        $arr = array();

        /**@var $setting Setting*/
        foreach ($settings as $setting){

            $value = $setting->value? $setting->value : $setting->default;

            settype($value, isset($setting->type)? $setting->type: 'string');

            $arr[$setting->domain.'.'.$setting->name] = $value;
        }

        return $arr;
    }

    /**
     * Register providers.
     */
    protected function registerProviders() : void
    {
        $this->app->register(ConsoleServiceProvider::class);
    }

    /**
     * Register Passport's migration files.
     *
     * @return void
     */
    protected function registerMigrations() : void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

    }

    protected function registerEvents() : void
    {

    }

    protected function fireSettingsEvent(): void
    {
        //Refreshed settings when a new one is added
        /** @var $setting Setting*/
        Setting::saved(function(){

            $settings = $this->getSettingsItems();

            setting()->set($settings);
        });
    }
}
