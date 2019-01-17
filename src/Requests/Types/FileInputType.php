<?php

namespace Foundry\Requests\Types;
use Foundry\Requests\Types\Traits\HasAction;


/**
 * Class FileType
 *
 * @package Foundry\Requests\Types
 */
class FileInputType extends InputType {

	use HasAction;

	public function __construct(
		string $name,
		string $action,
		string $label = null,
		bool $required = true,
		string $value = null,
		string $position = 'full',
		string $rules = null,
		string $id = null,
		string $placeholder = null
	) {
		$type = 'file';
		parent::__construct( $name, $label, $required, $value, $position, $rules, $id, $placeholder, $type );
		$this->setAction($action);
	}
}
