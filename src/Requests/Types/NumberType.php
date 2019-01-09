<?php

namespace Foundry\Requests\Types;


/**
 * Class NumberType
 *
 * @package Foundry\Requests\Types
 */
class NumberType extends TextType{

	protected $decimals;

	protected $max;

	protected $min;

	public function __construct(string $name,
		string $label= null,
		bool $required = true,
		string $value = null,
		string $position = 'full',
		string $rules = null,
		string $id = null,
		string $placeholder = null)
	{
		$type = 'number';
		parent::__construct($name, $label, $required, $value, $position, $rules, $id, $placeholder, $type);
	}

	public function setDecimals($decimals = null): NumberType
	{
		$this->decimals = $decimals;
		return $this;
	}

	public function getDecimals()
	{
		return $this->decimals;
	}

	public function setMin($value = null): NumberType
	{
		$this->min = $value;
		return $this;
	}

	public function getMin()
	{
		return $this->min;
	}

	public function setMax($value = null): NumberType
	{
		$this->max = $value;
		return $this;
	}

	public function getMax()
	{
		return $this->max;
	}

}
