<?php

namespace Foundry\Core\Requests\Types;

use Foundry\Core\Requests\Types\Traits\HasClass;
use Foundry\Core\Requests\Types\Traits\HasId;
use Foundry\Core\Requests\Types\Traits\HasLabel;
use Foundry\Core\Requests\Types\Traits\HasTitle;
use Foundry\Core\Requests\Types\Traits\HasAction;

/**
 * Class Type
 *
 * @package Foundry\Requests\Types
 */
class ButtonType extends BaseType {

	use HasId,
		HasLabel,
		HasClass,
		HasTitle,
		HasAction
		;

	/**
	 * The form row this field belongs to
	 *
	 */
	protected $row;

	protected $title;

	public function __construct(
		string $label,
		string $action = null,
		string $title = null,
		array $query = [],
		string $method = 'GET',
		string $id = null,
		string $type = 'action'
	) {
		$this->setLabel( $label );
		$this->setAction( $action );
		$this->setTitle( $title );
		$this->setQuery( $query );
		$this->setMethod( $method );
		$this->setType( $type );
		$this->setId( $id );
	}




}
