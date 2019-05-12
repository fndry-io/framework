<?php

namespace Foundry\Core\Providers;

use Foundry\Core\Console\Commands\GenerateModelCommand;
use Foundry\Core\Console\Commands\GeneratePluginCommand;
use Foundry\Core\Console\Commands\GenerateServiceCommand;
use Illuminate\Support\ServiceProvider;

/**
 * Class ConsoleServiceProvider
 *
 * @package Foundry\Providers
 *
 * @author Medard Ilunga
 */
class ConsoleServiceProvider extends ServiceProvider {
	protected $defer = false;

	/**
	 * The available commands
	 *
	 * @var array
	 */
	protected $commands = [
		GenerateModelCommand::class,
		GenerateServiceCommand::class,
		GeneratePluginCommand::class,
	];

	/**
	 * Register the commands.
	 */
	public function register() {
		$this->commands( $this->commands );
	}

	/**
	 * @return array
	 */
	public function provides() {
		$provides = $this->commands;

		return $provides;
	}
}
