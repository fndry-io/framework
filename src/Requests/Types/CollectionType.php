<?php

namespace Foundry\Core\Requests\Types;

use Foundry\Core\Requests\Types\Traits\HasButtons;
use Foundry\Core\Requests\Types\Traits\HasMinMax;
use Foundry\Core\Requests\Types\Traits\HasMultiple;
use Foundry\Core\Requests\Types\Traits\HasName;

class CollectionType extends ParentType {

	use HasMinMax,
		HasMultiple,
		HasButtons,
		HasName;

	public function __construct( $name ) {
		$this->setName( $name );
		$this->setType( 'collection' );
	}

}