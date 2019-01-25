<?php

namespace Foundry\Requests\Types;

use Foundry\Requests\Types\Contracts\Referencable;
use Foundry\Requests\Types\Traits\HasButtons;
use Foundry\Requests\Types\Traits\HasOptions;
use Foundry\Requests\Types\Traits\HasQueryOptions;

/**
 * Class ReferenceType
 *
 * A reference type is used to set hasOne, hasMany, belongsTo, belongsToMany
 *
 * @package Foundry\Requests\Types
 */
class ReferenceInputType extends TextInputType implements Referencable {

	use HasButtons;
	use HasQueryOptions;
	use HasOptions;

	/**
	 * @var string|object $reference
	 */
	protected $reference;

	/**
	 * Reference constructor
	 *
	 * @param string $name The field name
	 * @param string $label
	 * @param bool $required
	 * @param mixed $reference
	 * @param string $url The url to fetch the list of existing options
	 * @param null $value
	 * @param string $position
	 * @param string|null $rules
	 * @param string|null $id
	 * @param string|null $placeholder
	 * @param string $query_param
	 */
	public function __construct(
		string $name,
		string $label,
		bool $required = true,
		$reference,
		$url = null,
		$value = null,
		string $position = 'full',
		string $rules = null,
		string $id = null,
		string $placeholder = null,
		string $query_param = 'q'
	) {
		parent::__construct( $name, $label, $required, $value, $position, $rules, $id, $placeholder, 'reference' );
		$this->setUrl( $url );
		$this->setQueryParam( $query_param );
		$this->setReference($reference);
	}

	/**
	 * The reference
	 *
	 * @param string|object $reference
	 *
	 * @return $this
	 */
	public function setReference($reference)
	{
		$this->reference = $reference;
		return $this;
	}

	/**
	 * The reference string or object
	 *
	 * @return null|string|object
	 */
	public function getReference()
	{
		return $this->reference;
	}

	public function getReferenceLabel()
	{

	}

	/**
	 * Json serialise field
	 *
	 * @return array
	 */
	public function jsonSerialize(): array {

		//Do we have a reference
		//Is it a string, meaning we need to locate it on the current model
		$reference = $this->getReference();
		if ($reference && is_string($reference)) {
			if ($this->hasModel() && $reference = object_get($this->getModel(), $reference)) {
				$this->reference = $reference;
			} else {
				$this->reference = null;
			}
		}
		return parent::jsonSerialize();
	}

	public function addButton($label, $request, $title, $type)
	{
		$this->setButtons(
			( new ButtonType( $label, $request, $title ) )->setType( $type )
		);
		return $this;
	}


	public function hasReference(): bool
	{
		$reference = $this->getReference();
		if (is_object($reference) || ($this->hasModel() && $reference = object_get($this->getModel(), $reference))) {
			return true;
		}
		return false;
	}

	public function displayRef( $value = null ) {
		$reference = $this->getReference();
		if (is_object($reference) || ($this->hasModel() && $reference = object_get($this->getModel(), $reference))) {
			return $reference->label;
		}
		return null;
	}
}
