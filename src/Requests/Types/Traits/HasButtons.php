<?php

namespace Foundry\Requests\Types\Traits;

use Foundry\Requests\Types\ButtonType;
use Foundry\Requests\Types\InputType;

trait HasButtons {

	/**
	 * Buttons to add to the form input
	 *
	 * @var ButtonType[] The array of button types
	 */
	protected $buttons;

	/**
	 * Adds buttons to the input
	 *
	 * @param ButtonType ...$button
	 *
	 * @return $this
	 */
	public function setButtons(ButtonType &...$button)
	{
		foreach ($button as &$_button) {
			$this->buttons[] = $_button;
		}
		return $this;
	}

	/**
	 * Gets the buttons
	 *
	 * @return array
	 */
	public function getbuttons(): array
	{
		return $this->buttons;
	}

}