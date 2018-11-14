<?php

namespace Foundry\Requests\Types;


use Illuminate\Database\Eloquent\Model;

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

    /**
     * The form row this field belongs to
     *
     * @var FormRow $row
     */
    protected $row;

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
     *
     * @return Type
     */
    public function setName(string $name): Type
    {
        $this->name = $name;

        return $this;
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
     *
     * @return Type
     */
    public function setLabel(string $label): Type
    {
        $this->label = $label;

        return $this;
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
     *
     * @return Type
     */
    public function setType($type): Type
    {
        $this->type = $type;

        return $this;
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
     *
     * @return Type
     */
    public function setRules(string $rules): Type
    {
        $this->rules = $rules;

        return $this;
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
     *
     * @return Type
     */
    public function setRequired(bool $required): Type
    {
        $this->required = $required;

        return $this;
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
     *
     * @return Type
     */
    public function setPosition(string $position): Type
    {
        $this->position = $position;

        return $this;
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
     *
     * @return Type
     */
    public function setId(string $id): Type
    {
        $this->id = $id;

        return $this;
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
     *
     * @return Type
     */
    public function setValue($value): Type
    {
        $this->value = $value;

        return $this;
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
     *
     * @return Type
     */
    public function setPlaceholder($placeholder): Type
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    /**
     * @return FormRow
     */
    public function getRow(): FormRow
    {
        return $this->row;
    }

    /**
     * @param FormRow $row
     *
     * @return Type
     */
    public function setRow(FormRow $row): Type
    {
        $this->row = $row;

        return $this;
    }

    /**
     * Json serialise field
     *
     * @return array
     */
    public function jsonSerialize() : array{

        $field = array();
        $model = $this->getRow()->getForm()->getModel();

        foreach ($this as $key => $value) {

            if($key !== 'row'){
                if($key === 'value' && $model)
                    $field[$key] = $this->getModelValue($model);
                else
                    $field[$key] = $value;
            }

        }

        return $field;
    }

    /**
     * Get previously provided value from model
     *
     * @param Model $model
     * @return mixed
     */
    private function getModelValue(Model $model){

        return $model[$this->getName()];
    }
}
