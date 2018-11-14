<?php

namespace Foundry\Requests\Types;


/**
 * Class Type
 *
 * @package Foundry\Requests\Types
 */
abstract class Type {

    /**
     * Name of the field
     * @var string $name
     */
    protected $name;

    /**
     * Input id
     *
     * @var string $id
     */
    protected $id;

    /**
     * Label to display
     *
     * @var string $label
     */
    protected $label;

    /**
     * Type of the input to display
     *
     * @var $type
     */
    protected $type;

    /**
     * Validation rules as per Laravel validations
     *
     * @var string $rules
     */
    protected $rules;

    /**
     * Is this field required or not
     *
     * @var boolean $required
     */
    protected $required;

    /**
     * Position of the input (right, left, full(center))
     *
     * @var string $position
     */
    protected $position;

    /**
     * Value of the input
     *
     * @var mixed $value
     */
    protected $value;

    /**
     * Placeholder of the input
     *
     * @var mixed $placeholder
     */
    protected $placeholder;


    public function __construct(string $name,
                                string $label = '',
                                bool $required = true,
                                string $value = '',
                                string $position = 'full',
                                string $rules = '',
                                string $id = '',
                                string $placeholder = '',
                                string $type = 'text')
    {
        $this->setName($name);
        $this->setLabel($label? $label: $name);
        $this->setType($type);
        $this->setRequired($required);
        $this->setValue($value);
        $this->setPosition($position);
        $this->setRules($rules);

        $id = $id? $id: $name.'_field';

        $this->setId($id);
        $this->setPlaceholder($placeholder ? $placeholder: $label? $label: $name);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getRules(): string
    {
        return $this->rules;
    }

    /**
     * @param string $rules
     */
    public function setRules(string $rules): void
    {
        $this->rules = $rules;
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->required;
    }

    /**
     * @param bool $required
     */
    public function setRequired(bool $required): void
    {
        $this->required = $required;
    }

    /**
     * @return string
     */
    public function getPosition(): string
    {
        return $this->position;
    }

    /**
     * @param string $position
     */
    public function setPosition(string $position): void
    {
        $this->position = $position;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    /**
     * @param mixed $placeholder
     */
    public function setPlaceholder($placeholder): void
    {
        $this->placeholder = $placeholder;
    }

    /**
     * Json serialise field
     *
     * @return array
     */
    public function jsonSerialize() : array{

        $field = array();

        foreach ($this as $key => $value) {
            $field[$key] = $value;
        }

        return $field;
    }
}
