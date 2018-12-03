<?php

namespace Foundry\Requests\Types;


/**
 * Class TextType
 *
 * @package Foundry\Requests\Types
 */
class TextType extends Type{

	protected $multiline = false;

	public function setMultiline($state)
	{
		$this->multiline = $state;
		return $this;
	}

	public function isMultiline()
	{
		return $this->multiline;
	}
}
