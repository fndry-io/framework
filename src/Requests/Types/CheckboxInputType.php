<?php

namespace Foundry\Requests\Types;


/**
 * Class CheckboxType
 *
 * @package Foundry\Requests\Types
 */
class CheckboxInputType extends InputType {

	protected $checked;

	public function __construct(
		string $name,
		string $label = null,
		bool $required = true,
		string $value = null,
		bool $checked = false,
		string $position = 'full',
		string $rules = null,
		string $id = null,
		string $placeholder = null
	) {
		$type = 'switch';
		parent::__construct( $name, $label, $required, $value, $position, $rules, $id, $placeholder, $type );

		$this->setChecked( $checked );
	}

	public function isChecked() {
		return $this->checked;
	}

	public function setChecked( bool $checked = true ) {
		$this->checked = $checked;

		return $this;
	}

}
