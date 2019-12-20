<?php

namespace Foundry\Requests\Types;

use Foundry\Requests\Types\Contracts\Choosable;
use Foundry\Requests\Types\Traits\HasMinMax;
use Foundry\Requests\Types\Traits\HasOptions;

/**
 * Class ChoiceType
 *
 * @package Foundry\Requests\Types
 * @todo Update ChoiceType and others of a similar nature to rather use traits for the additional properties and methods
 */
class AjaxSelectInputType extends InputType implements Choosable {

	use HasOptions;
	use HasMinMax;

	protected $inline;
	protected $data_type;
	protected $url;

	public function __construct(
		string $name,
		string $label,
        bool $multiple,
        string $url,
        ?array $options = [],
		bool $required = true,
		$value = null,
		string $position = 'full',
		string $rules = null,
		string $id = null,
		string $placeholder = null
	) {
		$this->setMultiple( $multiple );
		$this->setOptions( $options );
		$this->setUrl($url);
		$type = 'ajax-select';

		parent::__construct( $name, $label, $required, $value, $position, $rules, $id, $placeholder, $type );
	}

	public function setDataType($data_type)
    {
        $this->data_type = $data_type;
        return $this;
    }

    public function getDataType()
    {
        return $this->data_type;
    }

	public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    public function getUrl()
    {
        return $this->url;
    }
	public function setInline($value = true)
	{
		$this->inline = $value;
		return $this;
	}

	public function getInline()
	{
		return $this->inline;
	}

	public function display($value = null) {

		if ($value === null) {
			$value = $this->getValue();
		}

		$options = $this->getOptions($value);

		if ( $value === '' || $value === null || ( $this->multiple && empty( $value ) ) ) {
			return null;
		}

		if ( empty( $options ) ) {
			return $value;
		}

		//make sure it is an array
		$value = (array) $value;
		$values = [];
		foreach ( $value as $key ) {
			if ( isset( $options[ $key ] ) ) {
				$values[] = $options[ $key ];
			}
		}
		if ( count( $values ) === 1 ) {
			return $values[0];
		} else {
			return $values;
		}
	}
}
