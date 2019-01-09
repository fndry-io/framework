<?php

namespace Foundry\Requests\Types;


/**
 * Class AutoCompleteType
 *
 * @package Foundry\Requests\Types
 */
class AutoCompleteType extends ChoiceType {

	/**
	 * @var string The query param
	 */
    protected $query_param;

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
        $type = 'autocomplete';
	    $this->setMultiple($multiple);
	    $this->setOptions($options);
	    $this->setQueryParam($query_param);
        parent::__construct($name, $label, $required, null, $position, $rules, $id, $placeholder, $type);
        $this->setValue($value);
    }

	/**
	 * @return string
	 */
	public function getQueryParam(): string
	{
		return $this->query_param;
	}

	/**
	 * @param string $query_param
	 *
	 * @return Type
	 */
	public function setQueryParam(string $query_param): Type
	{
		$this->query_param = $query_param;
		return $this;
	}

}
