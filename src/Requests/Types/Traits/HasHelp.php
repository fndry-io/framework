<?php

namespace Foundry\Requests\Types\Traits;

use Foundry\Requests\Types\InputType;

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
	public function getHelp(): string
	{
		return $this->help;
	}

	/**
	 * @param string $help
	 *
	 * @return InputType
	 */
	public function setHelp(string $help): InputType
	{
		$this->help = $help;

		return $this;
	}

}