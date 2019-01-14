<?php

namespace Foundry\Requests\Types;
use Foundry\Requests\Types\Traits\HasQueryOptions;


/**
 * Class AutoCompleteType
 *
 * @package Foundry\Requests\Types
 */
class AutoCompleteType extends ChoiceInputType {

	use HasQueryOptions;

	/**
	 * AutoCompleteType constructor.
	 *
	 * @param string $name The field name
	 * @param string $label
	 * @param array $options The options to display if not doing a url fetch for them
	 * @param string $url The url to fetch the list of available options from
	 * @param bool $multiple
	 * @param bool $required
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
        $this->setType('autocomplete');
    }
}
