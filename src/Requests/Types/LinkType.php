<?php

namespace Foundry\Core\Requests\Types;

use Foundry\Core\Requests\Types\Contracts\Inputable;
use Foundry\Core\Requests\Types\Traits\HasClass;
use Foundry\Core\Requests\Types\Traits\HasHelp;
use Foundry\Core\Requests\Types\Traits\HasId;
use Foundry\Core\Requests\Types\Traits\HasLabel;
use Foundry\Core\Requests\Types\Traits\HasModel;
use Foundry\Core\Requests\Types\Traits\HasName;
use Foundry\Core\Requests\Types\Traits\HasTitle;
use Foundry\Core\Requests\Types\Traits\HasValue;

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
        HasHelp
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
