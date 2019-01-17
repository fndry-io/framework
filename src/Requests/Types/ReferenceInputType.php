<?php

namespace Foundry\Requests\Types;

use Foundry\Requests\Types\Traits\HasQueryOptions;
use Foundry\Requests\Types\Traits\HasRequest;


/**
 * Class ReferenceType
 *
 * A reference type is used to set hasOne, hasMany, belongsTp, belongsToMany
 *
 * @package Foundry\Requests\Types
 */
class ReferenceInputType extends ChoiceInputType {

	use HasRequest;
	use HasQueryOptions;

	/**
	 * Reference constructor
	 *
	 * @param string $name The field name
	 * @param string $label
	 * @param array $options The options to display if not doing a url fetch for them
	 * @param string $url The url to fetch the list of available options. If this and options are null, then the Type the equivalent to a hasOne relationship
	 * @param bool $multiple
	 * @param bool $required
	 * @param string $request_url
	 * @param string $request_name
	 * @param string $request_id
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
		array $options,
		?string $url,
		bool $multiple,
		string $request_url,
		string $request_name,
		string $request_id = null,
		$value = null,
		string $position = 'full',
		string $rules = null,
		string $id = null,
		string $placeholder = null,
		string $query_param = 'q'
	) {
		parent::__construct( $name, $label, $required, false, $multiple, $options, $value, $position, $rules, $id, $placeholder );
		$this->setUrl( $url );
		$this->setQueryParam( $query_param );
		$this->setRequestUrl( $request_url );
		$this->setRequestName( $request_name );
		$this->setRequestId( $request_id );
		$this->setType( 'reference' );
	}

}
