<?php

namespace Foundry\Requests\Types;
use Foundry\Requests\Types\Traits\HasQueryOptions;
use Foundry\Requests\Types\Traits\HasRequest;


/**
 * Class BelongsToType
 *
 * @package Foundry\Requests\Types
 */
class BelongsToType extends ChoiceType {

	use HasRequest;
	use HasQueryOptions;

	/**
	 * BelongsToType constructor.
	 *
	 * @param string $name The field name
	 * @param string $label
	 * @param array $options The options to display if not doing a url fetch for them
	 * @param string $url The url to fetch the list of available options from
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
    public function __construct(string $name,
							    string $label,
	                            bool $required = true,
							    array $options,
							    string $url,
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
		)
    {
        parent::__construct($name, $label, $required, false, $multiple, $options, $value, $position, $rules, $id, $placeholder);
	    $this->setUrl($url);
	    $this->setQueryParam($query_param);
	    $this->setFormRequest($request_url, $request_name, $request_id);
        $this->setType('belongsto');
    }

}
