<?php

namespace Foundry\Requests\Types\Traits;

use Foundry\Requests\Types\InputType;

trait HasDescription {

	/**
	 * Description
	 *
	 * @var string $description
	 */
	protected $description;

	/**
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @param string $description
	 *
	 * @return InputType
	 */
	public function setDescription( string $description = null ) {
		$this->description = $description;

		return $this;
	}

}