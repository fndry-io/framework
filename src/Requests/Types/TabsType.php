<?php

namespace Foundry\Requests\Types;

/**
 * Class FormRow
 *
 * @package Foundry\Requests\Types
 */
class TabsType extends ParentType {

	/**
	 * TabsType constructor.
	 */
	public function __construct() {
		$this->setType( 'tabs' );
	}

}
