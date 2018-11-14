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
                                string $label = '',
                                bool $required = true,
                                string $value = '',
                                string $position = 'full',
                                string $rules = '',
                                string $id = '',
                                string $placeholder = '')
    {
        $this->setMultiple($multiple);
        $this->setOptions($options);

        $type = $expanded? $multiple? 'checkbox': 'radio' : 'select';

        parent::__construct($name, $label, $required, $value, $position, $rules, $id, $placeholder, $type);

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

}
