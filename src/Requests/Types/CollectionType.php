<?php

namespace Foundry\Requests\Types;

use Foundry\Requests\Types\Traits\HasButtons;
use Foundry\Requests\Types\Traits\HasMinMax;
use Foundry\Requests\Types\Traits\HasMultiple;

class CollectionType extends ParentType {

	use HasMinMax,
		HasMultiple,
		HasButtons
		;

	public function __construct() {
		$this->setType('collection');
	}

}