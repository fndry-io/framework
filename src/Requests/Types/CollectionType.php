<?php

namespace Foundry\Requests\Types;

use Foundry\Requests\Types\Traits\HasButtons;
use Foundry\Requests\Types\Traits\HasMinMax;
use Foundry\Requests\Types\Traits\HasMultiple;
use Foundry\Requests\Types\Traits\HasName;

class CollectionType extends ParentType {

	use HasMinMax,
		HasMultiple,
		HasButtons,
		HasName
		;

	public function __construct($name) {
		$this->setName($name);
		$this->setType('collection');
	}

}