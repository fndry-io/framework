<?php

namespace Foundry\Requests\Types;

/**
 * Class FormRow
 *
 * @package Foundry\Requests\Types
 */
class RowType extends ParentType {

	public function __construct() {
		$this->setType( 'row' );
	}

	//TODO remove references to this across the projects
	static function withInputs( InputType ...$inputs ) {
		return ( new static() )->addChildren( ...$inputs );
	}

	static function withChildren( BaseType ...$inputs ) {
		return ( new static() )->addChildren( ...$inputs );
	}

}
