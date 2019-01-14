<?php

namespace Foundry\Requests\Types;

use Foundry\Requests\Types\Traits\HasMinMax;


/**
 * Class NumberType
 *
 * @package Foundry\Requests\Types
 */
class NumberType extends TextInputType{

	use HasMinMax;

	protected $decimals;

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
		$this->addRule('numeric');
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


}
