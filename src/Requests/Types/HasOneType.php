<?php

namespace Foundry\Requests\Types;
use Foundry\Requests\Types\Traits\HasRequest;


/**
 * Class HasOneType
 *
 * @package Foundry\Requests\Types
 */
class HasOneType extends Type {

	use HasRequest;

	/**
	 * HasOneType constructor.
	 *
	 * @param string $name The field name
	 * @param string $label
	 * @param bool $required
	 * @param string $request_url
	 * @param string $request_name
	 * @param string $request_id
	 * @param null $value
	 * @param string $position
	 * @param string|null $rules
	 * @param string|null $id
	 * @param string|null $placeholder
	 */
    public function __construct(string $name,
							    string $label,
	                            bool $required = true,
                                string $request_url,
							    string $request_name,
	                            string $request_id = null,
                                $value = null,
                                string $position = 'full',
                                string $rules = null,
                                string $id = null,
                                string $placeholder = null
		)
    {
        parent::__construct($name, $label, $required, $value, $position, $rules, $id, $placeholder, 'hasone');
        $this->setFormRequest($request_url, $request_name, $request_id);
    }




}
