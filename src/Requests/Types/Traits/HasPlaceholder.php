<?php

namespace Foundry\Requests\Types\Traits;

use Foundry\Requests\Types\InputType;

trait HasPlaceholder {

	/**
	 * Placeholder
	 *
	 * @var string $placeholder
	 */
	protected $placeholder;

	/**
	 * @return string
	 */
	public function getPlaceholder(): string
	{
		return $this->placeholder;
	}

	/**
	 * @param string $placeholder
	 *
	 * @return InputType
	 */
	public function setPlaceholder(string $placeholder = null)
	{
		$this->placeholder = $placeholder;

		return $this;
	}

}