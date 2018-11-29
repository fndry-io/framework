<?php

namespace Foundry\Requests\Types;


/**
 * Class ChoiceType
 *
 * @package Foundry\Requests\Types
 */
class ChoiceType extends Type{

    /**
     * If it is select, does it allow multiple selections
     *
     * @var bool $multiple
     */
    protected $multiple;

    /**
     * Available options
     *
     * @var array $options
     */
    protected $options;

    public function __construct(string $name,
                                bool $expanded,
                                bool $multiple,
                                array $options,
                                string $label = null,
                                bool $required = true,
                                $value = null,
                                string $position = 'full',
                                string $rules = null,
                                string $id = null,
                                string $placeholder = null)
    {
        $this->setMultiple($multiple);
        $this->setOptions($options);

        $type = $expanded? $multiple? 'checkbox': 'radio' : 'select';

        parent::__construct($name, $label, $required, null, $position, $rules, $id, $placeholder, $type);

        $this->setValue($value);
    }

    /**
     * @return bool
     */
    public function isMultiple(): bool
    {
        return $this->multiple;
    }

    /**
     * @param bool $multiple
     *
     * @return Type
     */
    public function setMultiple(bool $multiple): Type
    {
        $this->multiple = $multiple;

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array $options
     *
     * @return Type
     */
    public function setOptions(array $options): Type
    {
        $this->options = $options;

        return $this;
    }

	/**
	 * Determines if a value is selected
	 *
	 * @param $key
	 *
	 * @return bool
	 */
    public function isOptionChecked($key)
    {
    	if (is_array($this->value)) {
		    return in_array($key, $this->value);
	    } elseif (is_string($this->value)) {
    		return $key == $this->value;
	    }
    	return false;
    }
    
}
