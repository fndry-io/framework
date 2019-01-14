<?php

namespace Foundry\Requests\Types\Traits;

use Foundry\Requests\Types\InputType;

trait HasMinMax {

	protected $max;

	protected $min;

	public function setMin($value = null): InputType
	{
		$this->min = $value;
		if (method_exists($this, 'addRule') && $value !== null) {
			$this->addRule('min:' . $value);
		}
		return $this;
	}

	public function getMin()
	{
		return $this->min;
	}

	public function setMax($value = null): InputType
	{
		$this->max = $value;
		if (method_exists($this, 'addRule') && $value !== null) {
			$this->addRule('max:' . $value);
		}
		return $this;
	}

	public function getMax()
	{
		return $this->max;
	}


}