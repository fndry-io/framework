<?php

namespace Foundry\Requests\Types\Traits;

use Foundry\Requests\Types\InputType;

trait HasReadonly {

	/**
	 * Readonly
	 *
	 * @var string $readonly
	 */
	protected $readonly = false;

	/**
	 * @return bool
	 */
	public function isReadonly(): bool
	{
		return $this->readonly;
	}

	/**
	 * @param string $readonly
	 *
	 * @return InputType
	 */
	public function setReadonly(string $readonly): InputType
	{
		$this->readonly = $readonly;

		return $this;
	}

}