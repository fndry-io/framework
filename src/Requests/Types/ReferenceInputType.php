<?php

namespace Foundry\Requests\Types;

use Foundry\Requests\Types\Traits\HasButtons;


/**
 * Class ReferenceType
 *
 * A reference type is used to set hasOne, hasMany, belongsTp, belongsToMany
 *
 * @package Foundry\Requests\Types
 */
class ReferenceInputType extends ChoiceInputType {

	use HasButtons;

	/**
	 * Reference constructor
	 *
	 * @param string $name The field name
	 * @param string $label
	 * @param array $options The options to display if not doing a url fetch for them
	 * @param bool $required
	 * @param null $value
	 * @param string $position
	 * @param string|null $rules
	 * @param string|null $id
	 * @param string|null $placeholder
	 */
	public function __construct(
		string $name,
		string $label,
		bool $required = true,
		array $options,
		$value = null,
		string $position = 'full',
		string $rules = null,
		string $id = null,
		string $placeholder = null
	) {
		parent::__construct( $name, $label, $required, false, false, $options, $value, $position, $rules, $id, $placeholder );
		$this->setType( 'reference' );
	}

}
