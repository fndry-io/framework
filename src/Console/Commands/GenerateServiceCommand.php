<?php

namespace Foundry\Core\Console\Commands;

use Illuminate\Support\Str;
use Nwidart\Modules\Support\Config\GenerateConfigReader;
use Nwidart\Modules\Support\Stub;
use Nwidart\Modules\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class GenerateServiceCommand
 *
 * @package Foundry\Console\Commands
 *
 * @author Medard Ilunga
 */
class GenerateServiceCommand extends BaseCommand {
	use ModuleCommandTrait;

	/**
	 * The name of argument name.
	 *
	 * @var string
	 */
	protected $argumentName = 'service';

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'foundry:service';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create a new service class for the specified plugin.';

	/**
	 * Get controller name.
	 *
	 * @return string
	 */
	public function getDestinationFilePath() {
		$path = $this->laravel['modules']->getModulePath( str_replace( '_', DIRECTORY_SEPARATOR, $this->getModuleName() ) );

		$servicePath = GenerateConfigReader::read( 'services' );

		return $path . $servicePath->getPath() . '/' . $this->getServiceName() . '.php';
	}

	/**
	 * @return string
	 */
	protected function getTemplateContents() {
		$module = $this->laravel['modules']->findOrFail( $this->getModuleName() );

		return ( new Stub( $this->getStubName(), [
			'MODULENAME'       => $module->getStudlyName(),
			'NAMESPACE'        => $module->getStudlyName(),
			'CLASS_NAMESPACE'  => $this->getClassNamespace( $module ),
			'CLASS'            => $this->getServiceNameWithoutNamespace(),
			'MODULE'           => $this->getModuleName(),
			'NAME'             => $this->getModuleName(),
			'STUDLY_NAME'      => $module->getStudlyName(),
			'FORM_NAMESPACE'   => $this->getFormRequestNamespace(),
			'MODEL_NAMESPACE'  => $this->getModelNamespace(),
			'MODULE_NAMESPACE' => $this->laravel['modules']->config( 'namespace' ),
		] ) )->render();
	}

	protected function getModelNamespace() {
		$file = $this->getDir() . '/app/Models/' . $this->getFileName() . '.php';

		// TODO throw exception if no model exists
		if ( file_exists( base_path( $file ) ) ) {
			return str_replace( '/', '\\', $this->getDir() ) . '\Models\\' . $this->getFileName();
		} else {
			return null;
		}
	}

	protected function getFormRequestNamespace() {
		$file = $this->getDir() . '/app/Http/Requests/' . $this->getFileName() . '.php';

		// TODO throw exception if no form request exists
		if ( file_exists( base_path( $file ) ) ) {
			return str_replace( '/', '\\', $this->getDir() ) . '\Http\Requests\\' . $this->getFileName();
		} else {
			return null;
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments() {
		return [
			[ 'service', InputArgument::REQUIRED, 'The name of the service class to be created.' ],
			[ 'module', InputArgument::OPTIONAL, 'The name of the plugin to be used.' ],
		];
	}

	/**
	 * @return array|string
	 */
	protected function getServiceName() {
		$service = studly_case( $this->argument( 'service' ) );

		if ( str_contains( strtolower( $service ), 'service' ) === false ) {
			$service .= 'Service';
		}

		return $service;
	}

	/**
	 * @return array|string
	 */
	private function getServiceNameWithoutNamespace() {
		return class_basename( $this->getServiceName() );
	}

	public function getDefaultNamespace(): string {
		return $this->laravel['modules']->config( 'paths.generator.services.path', 'Services' );
	}

	/**
	 * Get the stub file name
	 * @return string
	 */
	private function getStubName() {
		return '/service.stub';
	}

	/**
	 * @return string
	 */
	private function getFileName() {
		return Str::studly( $this->argument( 'service' ) );
	}
}
