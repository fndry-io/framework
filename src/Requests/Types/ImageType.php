<?php

namespace Foundry\Core\Requests\Types;

use Foundry\Core\Requests\Types\Contracts\Inputable;
use Foundry\Core\Requests\Types\Traits\HasClass;
use Foundry\Core\Requests\Types\Traits\HasHelp;
use Foundry\Core\Requests\Types\Traits\HasId;
use Foundry\Core\Requests\Types\Traits\HasLabel;
use Foundry\Core\Requests\Types\Traits\HasModel;
use Foundry\Core\Requests\Types\Traits\HasName;
use Foundry\Core\Requests\Types\Traits\HasValue;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ImageType
 *
 * @package Foundry\Requests\Types
 */
class ImageType extends BaseType implements Inputable {

	use HasId,
		HasLabel,
		HasClass,
        HasName,
        HasModel,
        HasValue,
        HasHelp
		;

	protected $alt;

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
		string $alt = null,
		string $id = null
	) {
		$this->setLabel( $label );
		$this->setName($name);
		$this->setAlt($alt);
		$this->setType( 'image' );
		$this->setId( $id );
	}

	public function getAlt(){
	    return $this->alt;
    }

    /**
     * @param $alt
     *
     * @return ImageType
     */
    public function setAlt($alt): ImageType{
	    $this->alt = $alt;
	    return $this;
    }

    public function display($value = null) {
        $value = $this->getValue();
        return $value;
    }
}
