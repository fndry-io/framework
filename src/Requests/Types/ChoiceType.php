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

    protected $expanded;

	/**
	 * @var mixed The empty option. Null or false for none. True for default text or a string for the displayed text
	 */
    protected $empty;

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
        $this->setExpanded($expanded);
        $type = $expanded? $multiple? 'checkbox': 'radio' : 'select';

        parent::__construct($name, $label, $required, null, $position, $rules, $id, $placeholder, $type);

        $this->setValue($value);
    }

    /**
     * @return mixed
     */
    public function isExpanded()
    {
        return $this->expanded;
    }

    /**
     * @param mixed $expanded
     */
    public function setExpanded($expanded): void
    {
        $this->expanded = $expanded;
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
    	$options = $this->options;
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

    public function setEmpty($value)
    {
    	$this->empty = $value;
    	return $this;
    }

	public function getEmpty($value)
	{
		return $this->empty;
	}

	public function getEmptyLabel($default = null)
	{
		if ($this->empty === true) {
			if ($default !== null) {
				return $default;
			} else {
				return __('Select one');
			}
		} elseif (is_string($this->empty)) {
			return $this->empty;
		}
	}

	public function hasEmptyOption()
	{
		return !!($this->empty);
	}

}
