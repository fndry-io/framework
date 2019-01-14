<?php

namespace Foundry\Requests\Types;

/**
 * Class FormRow
 *
 * @package Foundry\Requests\Types
 */
class RowType extends ParentType {

	public function __construct() {
		$this->setType('row');
	}
}
