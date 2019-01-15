<?php

namespace Foundry\Requests\Types;

use Foundry\Requests\Types\Traits\HasMinMax;


/**
 * Class EmailType
 *
 * @package Foundry\Requests\Types
 */
class EmailInputType extends InputType {

	use HasMinMax;

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
		$type = 'email';
		parent::__construct( $name, $label, $required, $value, $position, $rules, $id, $placeholder, $type );
	}
}
