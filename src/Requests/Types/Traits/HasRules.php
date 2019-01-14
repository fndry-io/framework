<?php

namespace Foundry\Requests\Types\Traits;

use Foundry\Requests\Types\InputType;

trait HasRules {

	/**
	 * Rules to display
	 *
	 * @var array $rules
	 */
	protected $rules = null;

	/**
	 * @return string|array
	 */
	public function getRules()
	{
		return $this->rules;
	}

	/**
	 * @param string|array $rules
	 *
	 * @return InputType
	 */
	public function setRules($rules = null): InputType
	{
		$this->rules = $rules;
		return $this;
	}

}