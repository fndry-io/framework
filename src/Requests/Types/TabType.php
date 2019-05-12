<?php

namespace Foundry\Core\Requests\Types;

use Foundry\Core\Requests\Types\Traits\HasId;
use Foundry\Core\Requests\Types\Traits\HasLabel;

/**
 * Class FormRow
 *
 * @package Foundry\Requests\Types
 */
class TabType extends ParentType {

	use HasLabel,
		HasId;

	public function __construct( $label, $id = null ) {
		$this->setType( 'tab' );

		$this->setLabel( $label );
		$id = $id ? $id : camel_case( str_slug( $label ) . 'Tab' );
		$this->setId( $id );
	}

}
