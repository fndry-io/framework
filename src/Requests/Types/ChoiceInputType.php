<?php

namespace Foundry\Requests\Types;

use Foundry\Requests\Types\Traits\HasMinMax;
use Foundry\Requests\Types\Traits\HasOptions;

/**
 * Class ChoiceType
 *
 * @package Foundry\Requests\Types
 * @todo Update ChoiceType and others of a similar nature to rather use traits for the additional properties and methods
 */
class ChoiceInputType extends InputType {

	use HasOptions;
	use HasMinMax;

	public function __construct(
		string $name,
		string $label = null,
		bool $required = true,
		bool $expanded,
		bool $multiple,
		array $options,
		$value = null,
		string $position = 'full',
		string $rules = null,
		string $id = null,
		string $placeholder = null
	) {
		$this->setMultiple( $multiple );
		$this->setOptions( $options );
		$this->setExpanded( $expanded );
		$type = $expanded ? $multiple ? 'checkbox' : 'radio' : 'select';

		parent::__construct( $name, $label, $required, $value, $position, $rules, $id, $placeholder, $type );
	}

	public function display($value = null) {
		if ( is_callable( $this->options ) ) {
			$call = $this->options;
			$options = $call();
		} else {
			$options = $this->options;
		}

		$value = $this->getValue();

		if ( $value === '' || $value === null || ( $this->multiple && empty( $value ) ) ) {
			return '-- ' . __( 'NOT SET' ) . ' ---';
		}

		if ( empty( $options ) ) {
			return $value;
		}

		if ( ! $this->multiple ) {
			$value = (array) $value;
		}
		$values = [];
		foreach ( $value as $key ) {
			if ( isset( $options[ $key ] ) ) {
				$values[] = $options[ $key ];
			}
		}
		if ( count( $values ) === 1 ) {
			return $values[0];
		} else {
			return $values;
		}
	}
}
