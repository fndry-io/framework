<?php

namespace Foundry\Requests\Types;

use Foundry\Requests\Types\Contracts\Inputable;
use Foundry\Requests\Types\Traits\HasClass;
use Foundry\Requests\Types\Traits\HasHelp;
use Foundry\Requests\Types\Traits\HasId;
use Foundry\Requests\Types\Traits\HasLabel;
use Foundry\Requests\Types\Traits\HasModel;
use Foundry\Requests\Types\Traits\HasName;
use Foundry\Requests\Types\Traits\HasTitle;
use Foundry\Requests\Types\Traits\HasValue;
use Foundry\Requests\Types\Traits\IsSortable;

/**
 * Class LinkType
 *
 * @package Foundry\Requests\Types
 */
class LinkType extends BaseType implements Inputable {

	use HasId,
		HasLabel,
		HasClass,
		HasTitle,
        HasName,
        HasModel,
        HasValue,
        HasHelp,
        IsSortable
		;

	/**
	 * The form row this field belongs to
	 *
	 * @var FormRow $row
	 */
	protected $row;

	protected $title;

	public function __construct(
		string $name,
		string $label,
		string $title = null,
		string $id = null
	) {
		$this->setLabel( $label );
		$this->setName($name);
		$this->setTitle( $title );
		$this->setType( 'link' );
		$this->setId( $id );
	}

    public function display($value = null) {
        $value = $this->getValue();
        return $value;
    }
}
