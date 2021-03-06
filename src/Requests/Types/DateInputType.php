<?php

namespace Foundry\Requests\Types;

use Foundry\Requests\Types\Traits\HasDateFormat;
use Foundry\Requests\Types\Traits\HasMinMax;


/**
 * Class DateType
 *
 * @package Foundry\Requests\Types
 */
class DateInputType extends InputType {

	use HasMinMax;
	use HasDateFormat;

	protected $format = "Y-m-d";

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
		$type = 'date';
		parent::__construct( $name, $label, $required, $value, $position, $rules, $id, $placeholder, $type );
		$this->addRule( 'date' );
	}

	static function cast()
	{
		return 'datetime';
	}

}
