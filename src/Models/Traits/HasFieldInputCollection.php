<?php

namespace Foundry\Models\Traits;

use Foundry\Models\FieldType;
use Foundry\Models\InputCollection;

/**
 * Trait HasInputCollection
 *
 * Allows us to generate a list of Input Types for a Model
 *
 * @package Foundry\Models\Traits
 */
trait HasFieldInputCollection {

	public function inputs( array $names, $collection = null ): InputCollection {
		if ( $collection ) {
			$collection = $collection . '.';
		}
		$inputs = new InputCollection();
		foreach ( $names as $key => $value ) {
			//have we been given a custom InputType
			if ( is_object( $value ) ) {
				$input = $value;
				//have we been given a custom input name
				if ( is_string( $key ) ) {
					$key = $collection . $key;
				} else {
					$key = $collection . $input->getName();
				}

				$input->setName( $key );
				$inputs->offsetSet( $key, $input );

			} //have we been given a default input, meaning the key to find on the model::$inputs where we will get the InputType class
			else if ( is_string( $value ) && isset( static::$inputs[ $value ] ) ) {
				/**
				 * @var FieldType $field
				 */
				$field = static::$inputs[ $value ];
				$input = $field::input( $this );
				$key   = $collection . $input->getName();

				$input->setName( $key );
				$inputs->offsetSet( $key, $input );
			}
		}

		return $inputs;
	}
}