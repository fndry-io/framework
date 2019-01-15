<?php

namespace Foundry\Requests\Types\Traits;

use Foundry\Requests\Types\InputType;

trait HasName {

	/**
	 * Name
	 *
	 * @var string $name
	 */
	protected $name;

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 *
	 * @return InputType
	 */
	public function setName(string $name)
	{
		$this->name = $name;

		return $this;
	}

}