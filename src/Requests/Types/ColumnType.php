<?php

namespace Foundry\Core\Requests\Types;

/**
 * Class FormRow
 *
 * @package Foundry\Requests\Types
 */
class ColumnType extends ParentType {

	public function __construct() {
		$this->setType( 'column' );
	}

	static function withChildren( BaseType ...$inputs ) {
		return ( new static() )->addChildren( ...$inputs );
	}

}
