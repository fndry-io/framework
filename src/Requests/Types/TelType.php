<?php

namespace Foundry\Requests\Types;


/**
 * Class TextType
 *
 * @package Foundry\Requests\Types
 */
class TelType extends TextType{

	public function __construct(
		string $name,
		string $label = null,
		bool $required = true,
		string $value = null,
		string $position = 'full',
		string $rules = null,
		string $id = null,
		string $placeholder = null)
	{
		$type = 'tel';
		parent::__construct($name, $label, $required, $value, $position, $rules, $id, $placeholder, $type);
	}
}
