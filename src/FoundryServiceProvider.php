<?php

namespace Foundry;

use Foundry\Config\SettingRepository;
use Foundry\Contracts\Repository;
use Foundry\Models\Listeners\SettingSaved;
use Foundry\Providers\ConsoleServiceProvider;
use Foundry\Providers\EventServiceProvider;
use Foundry\Requests\FormRequestHandler;
use Foundry\View\Components\ViewComponentHandler;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class FoundryServiceProvider extends ServiceProvider {
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Booting the package.
	 */
	public function boot() {

		$this->registerNamespaces();

		if ( $this->app->runningInConsole() ) {
			$this->registerMigrations();

			$this->publishes( [
				__DIR__ . '/../database/migrations' => database_path( 'migrations' ),
			], 'foundry-migrations' );
		}
	}

	/**
	 * Register all modules.
	 */
	public function register() {
		$this->registerServices();
		$this->registerProviders();
	}

	/**
	 * Register package's namespaces.
	 */
	protected function registerNamespaces() {
		$moduleConfigPath = __DIR__ . '/../config/modules.php';
		$configPath       = __DIR__ . '/../config/config.php';

		$this->mergeConfigFrom( $moduleConfigPath, 'modules' );
		$this->mergeConfigFrom( $configPath, 'foundry' );

		$this->publishes( [
			$moduleConfigPath => config_path( 'modules.php' ),
			$configPath       => config_path( 'foundry.php' )
		], 'config' );

	}

	/**
	 * Register the service provider.
	 */
	protected function registerServices() {

		$this->app->singleton( Repository::class, function () {

			if ( Cache::has( 'settings' ) ) {
				$settings = Cache::get( 'settings' );
			} else {
				$settings = SettingSaved::getSettingsItems();
				Cache::put( 'settings', $settings, now()->addDays( 30 ) );
			}

			return new SettingRepository( $settings );
		} );

		$this->app->alias( Repository::class, 'settings' );

		/**
		 * Register the FormRequestHandler Facade and link it to the FormRequestHandler Class
		 */
		$this->app->singleton( 'Foundry\Facades\FormRequestHandler', function () {
			return new FormRequestHandler();
		} );
		$this->app->alias( 'Foundry\Facades\FormRequestHandler', 'form-request-handler' );

		/**
		 * Register the ViewComponentHandler Facade and link it to the FormRequestHandler Class
		 */
		$this->app->singleton( 'Foundry\Facades\ViewComponentHandler', function () {
			return new ViewComponentHandler($this->app->get('request'));
		} );
		$this->app->alias( 'Foundry\Facades\ViewComponentHandler', 'view-component-handler' );

	}

	/**
	 * Get the services provided by the provider.
	 *
	 */
	public function provides(): void {

	}

	/**
	 * Register providers.
	 */
	protected function registerProviders(): void {
		$this->app->register( ConsoleServiceProvider::class );
		$this->app->register( EventServiceProvider::class );
	}

	/**
	 * Register Passport's migration files.
	 *
	 * @return void
	 */
	protected function registerMigrations(): void {

		//TODO this should publish them, not run them
		//$this->loadMigrationsFrom( __DIR__ . '/../database/migrations' );

	}

}
