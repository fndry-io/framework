<?php

namespace Foundry\Requests\Types;

use Foundry\Requests\Types\Traits\HasClass;
use Foundry\Requests\Types\Traits\HasDescription;
use Foundry\Requests\Types\Traits\HasId;
use Foundry\Requests\Types\Traits\HasTitle;

/**
 * Class Type
 *
 * @package Foundry\Requests\Types
 */
class SectionType extends ParentType {

	use HasId,
		HasClass,
		HasTitle,
		HasDescription;

	/**
	 * Type of the input to display
	 *
	 * @var $type
	 */
	protected $type;

	/**
	 * SectionType constructor.
	 *
	 * @param string $title
	 * @param string|null $description
	 * @param string|null $id
	 */
	public function __construct( string $title, string $description = null, string $id = null ) {
		$this->setType( 'section' );

		$this->setTitle( $title );
		$this->setDescription( $description );
		$id = $id ? $id : camel_case( str_slug( $title ) . 'Section' );
		$this->setId( $id );
	}

}
