<?php

namespace Foundry\Requests\Types\Traits;

use Foundry\Requests\Types\InputType;
use Illuminate\Contracts\Validation\Rule;

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
		if (isset($this->required)) {
			$this->addRule('required');
		} else {
			$this->addRule('nullable');
		}
		if (isset($this->options)) {
			if (is_array($this->options)) {
				$this->addRule(\Illuminate\Validation\Rule::in($this->getOptions()));
			}
		}
		return $this->rules;
	}

	/**
	 * @param string|array $rules
	 *
	 * @return $this
	 */
	public function setRules($rules = null): InputType
	{
		if (is_string($rules)) {
			$rules = explode('|', $rules);
		}
		foreach ($rules as $key => $value) {
			$this->addRule($value, $key);
		}
		$this->rules = $rules;
		return $this;
	}

	/**
	 * Adds a rule to the rules
	 *
	 * @param string|Rule $rule The rule to add
	 * @param null $key If the key given is a string, it will use it, if an integer it will ignore and just add the rule to the existing array
	 * @return $this
	 */
	public function addRule($rule, $key = null)
	{
		if (empty($this->rules)) {
			$this->rules = [];
		}
		if ($key && is_string($key)) {
			$this->rules[$key] = $rule;
		} else {
			$this->rules[] = $rule;
		}
		return $this;
	}
}