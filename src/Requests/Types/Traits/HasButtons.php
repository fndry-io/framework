<?php

namespace Foundry\Core\Requests\Types\Traits;

use Foundry\Core\Requests\Types\ButtonType;
use Foundry\Core\Requests\Types\InputType;

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
	 * @param ButtonType ...$buttons
	 *
	 * @return $this
	 */
	public function setButtons( ButtonType ...$buttons ) {
		foreach ( $buttons as $button ) {
			$this->buttons[] = $button;
		}

		return $this;
	}

	/**
	 * Gets the buttons
	 *
	 * @return array
	 */
	public function getButtons(): array {
		return $this->buttons;
	}

	public function hasButtons() {
		return ! empty( $this->buttons );
	}

}