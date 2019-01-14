<?php

namespace Foundry\Requests\Types\Traits;

use Foundry\Requests\Types\InputType;

trait HasRequired {

	/**
	 * Required
	 *
	 * @var string $required
	 */
	protected $required;

	/**
	 * @return bool
	 */
	public function isRequired(): bool
	{
		return $this->required;
	}

	/**
	 * @param string $required
	 *
	 * @return InputType
	 */
	public function setRequired(string $required): InputType
	{
		$this->required = $required;

		return $this;
	}

}