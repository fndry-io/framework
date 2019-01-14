<?php

namespace Foundry\Requests\Types\Traits;

use Foundry\Requests\Types\InputType;

trait HasPosition {

	/**
	 * Position
	 *
	 * @var string $position
	 */
	protected $position;

	/**
	 * @return string
	 */
	public function getPosition(): string
	{
		return $this->position;
	}

	/**
	 * @param string $position
	 *
	 * @return InputType
	 */
	public function setPosition(string $position): InputType
	{
		$this->position = $position;

		return $this;
	}

}