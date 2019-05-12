<?php

namespace Foundry\Core\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class GeneratePluginCommand
 *
 * @package Foundry\Console\Commands
 *
 * @author Medard Ilunga
 */
class GeneratePluginCommand extends Command {
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'foundry:plugin';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create a new Plugin.';

	/**
	 * Execute the console command.
	 */
	public function handle() {
		$this->call( 'module:make', array(
			'name'    => $this->argument( 'name' ),
			'--plain' => $this->option( 'plain' ),
			'--force' => $this->option( 'force' ),
		) );
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments() {
		return [
			[ 'name', InputArgument::IS_ARRAY, 'The names of plugins that will be created.' ],
		];
	}

	protected function getOptions() {
		return [
			[ 'plain', 'p', InputOption::VALUE_NONE, 'Generate a plain Plugin (without some resources).' ],
			[ 'force', null, InputOption::VALUE_NONE, 'Force the operation to run when the plugin already exists.' ],
		];
	}
}
