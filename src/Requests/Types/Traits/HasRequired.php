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
	 * @param bool $required
	 *
	 * @return InputType
	 */
	public function setRequired(bool $required): InputType
	{
		$this->required = $required;
		return $this;
	}

}