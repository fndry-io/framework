<?php

namespace Foundry\Core\Requests\Types\Traits;

use Foundry\Core\Requests\Types\InputType;

trait HasHelp {

	/**
	 * Help
	 *
	 * @var string $help
	 */
	protected $help;

	/**
	 * @return string
	 */
	public function getHelp() {
		return $this->help;
	}

	/**
	 * @param string $help
	 *
	 * @return InputType
	 */
	public function setHelp( string $help = null ) {
		$this->help = $help;

		return $this;
	}

}