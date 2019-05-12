<?php

namespace Foundry\Core\Requests\Types;

use Foundry\Core\Requests\Types\Traits\HasClass;
use Foundry\Core\Requests\Types\Traits\HasId;

/**
 * Class FormView
 *
 * @package Foundry\Requests\Types
 */
class DocType extends ParentType {


	use HasId,
		HasClass;

	/**
	 * DocType constructor.
	 *
	 * @param null $id
	 */
	public function __construct( $id = null ) {
		$this->setId( $id );
		$this->setType( 'doc' );
	}

	static function withChildren( BaseType ...$children )
	{
		return ( new static() )->addChildren( ...$children );
	}

}
