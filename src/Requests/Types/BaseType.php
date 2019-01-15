<?php

namespace Foundry\Requests\Types;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Class Type
 *
 * @package Foundry\Requests\Types
 */
abstract class BaseType implements Arrayable {

	/**
	 * Type of the input to display
	 *
	 * @var $type
	 */
	protected $type;

	/**
	 * @return mixed
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * @param mixed $type
	 *
	 * @return InputType
	 */
	public function setType($type = null)
	{
		$this->type = $type;
		return $this;
	}

	public function toArray() {
		return $this->jsonSerialize();
	}

	/**
	 * Json serialise field
	 *
	 * @return array
	 */
	public function jsonSerialize() : array
	{

		$field = array();

		//set all the object properties
		foreach ($this as $key => $value) {
			$field[$key] = $value;
		}

		//set required into the rules

		return $field;
	}


}
