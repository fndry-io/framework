<?php

namespace Foundry\Requests\Types\Traits;

use Foundry\Requests\Types\InputType;

trait HasLabel {
	/**
	 * Label to display
	 *
	 * @var string $label
	 */
	protected $label;

	/**
	 * @return string
	 */
	public function getLabel(): string
	{
		return $this->label;
	}

	/**
	 * @param string $label
	 *
	 * @return InputType
	 */
	public function setLabel(string $label = null)
	{
		$this->label = $label;

		return $this;
	}

}