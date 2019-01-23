<?php

namespace Foundry\Requests\Types;

use Foundry\Requests\Types\Contracts\Choosable;
use Foundry\Requests\Types\Contracts\Inputable;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Class Type
 *
 * @package Foundry\Requests\Types
 */
abstract class BaseType implements Arrayable {

	protected $json_ignore = [];

	/**
	 * Type of the input to display
	 *
	 * @var $type
	 */
	protected $type;

	/**
	 * @return mixed
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @param mixed $type
	 *
	 * @return InputType
	 */
	public function setType( $type = null ) {
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
	public function jsonSerialize(): array {

		$field = array();

		//set all the object properties
		foreach ( $this as $key => $value ) {

			if ( $key == 'json_ignore' || in_array( $key, $this->json_ignore ) ) {
				continue;
			}

			if ( is_array( $value ) ) {
				$_value = [];
				foreach ( $value as $index => $child ) {
					if ( is_object( $child ) && $child instanceof Arrayable ) {
						$_value[$index] = $child->toArray();
					} else {
						$_value[$index] = $child;
					}
				}
				$value = $_value;
			}

			$field[ $key ] = $value;
		}

		//set required into the rules

		return $field;
	}

	public function isInputType() {
		return $this instanceof Inputable;
	}

	public function isChoiceType() {
		return $this instanceof Choosable;
	}


}
