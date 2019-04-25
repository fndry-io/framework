<?php

namespace Foundry\Requests\Types;

use Foundry\Requests\Types\Contracts\Choosable;
use Foundry\Requests\Types\Contracts\Inputable;
use Foundry\Requests\Types\Traits\HasConditions;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;

/**
 * Class Type
 *
 * @package Foundry\Requests\Types
 */
abstract class BaseType implements Arrayable {

	use HasConditions;

    protected $json_ignore = ['model', 'not_callable'];

    protected $not_callable = ['type', 'url', 'file', 'date'];

	/**
	 * Type of the input to display
	 *
	 * @var $type
	 */
	protected $type;

	/**
	 * @var array|null A store for additional information
	 */
	protected $data = null;

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


	public function getData($key = null, $default = null)
	{
		if ($key) {
			return Arr::get($this->data, $key, $default);
		} else {
			return $this->data;
		}

	}

	/**
	 * Set the additional data for the input
	 *
	 * @param array $data
	 *
	 * @return InputType
	 */
	public function setData(array $data = [])
	{
		$this->data = $data;
		return $this;
	}

	public function isType($type)
	{
		return ($this->type === $type);
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
			} elseif ( is_callable( $value ) ) {
                if(!in_array(is_string($key)? strtolower($key): $key, $this->not_callable) && !in_array(is_string($value)? strtolower($value): $value, $this->not_callable)){
                    $value = call_user_func($value);
                }
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
