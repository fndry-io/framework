<?php

namespace Foundry\Core\Inputs\Types;

use Foundry\Core\Inputs\Types\Traits\HasMinMax;


/**
 * Class NumberType
 *
 * @package Foundry\Requests\Types
 */
class NumberInputType extends TextInputType {

	use HasMinMax;

	protected $decimals;

	public function __construct(
		string $name,
		string $label = null,
		bool $required = true,
		string $value = null,
		string $position = 'full',
		string $rules = null,
		string $id = null,
		string $placeholder = null
	) {
		$type = 'number';
		parent::__construct( $name, $label, $required, $value, $position, $rules, $id, $placeholder, $type );
		$this->addRule( 'numeric' );
	}

	public function setDecimals( $decimals = null ) {
		$this->decimals = $decimals;

		return $this;
	}

	public function getDecimals() {
		return $this->decimals;
	}


}
