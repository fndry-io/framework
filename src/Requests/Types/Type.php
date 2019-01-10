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

	protected $readonly = false;

	protected $error;

	protected $help;

	protected $class;

	protected $fillable;

	/**
	 * @var int The number of rows to display if multiple
	 */
	protected $rows;

	/**
	 * The form row this field belongs to
	 *
	 * @var FormRow $row
	 */
	protected $row;

	public function __construct(string $name,
		string $label = null,
		bool $required = true,
		string $value = null,
		string $position = 'full',
		string $rules = null,
		string $id = null,
		string $placeholder = null,
		string $type = 'text')
	{
		$this->setName($name);
		$this->setType($type);
		$this->setRequired($required);

		$this->setLabel($label? $label: $name);
		$this->setValue($value);
		$this->setPosition($position);
		$this->setRules($rules);

		$id = $id? $id: camel_case(str_slug($name.'_field'));

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
	public function setLabel(string $label = null): Type
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
		if (isset($this->rules[$key])) {
			return $this->rules[$key];
		} else {
			return $this->getRow()->getForm()->getRule($this->name);
		}
	}

	/**
	 * @param string $rules
	 *
	 * @return Type
	 */
	public function setRules(string $rules = null): Type
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
	public function setPosition(string $position = null): Type
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

	public function isFillable()
	{
		if ($this->fillable === true) {
			return true;
		} else {
			return $this->getRow()->getForm()->isFieldFillable($this->name);
		}
	}

	public function isGuarded()
	{
		return $this->getRow()->getForm()->isFieldGuarded($this->name);
	}

	public function isVisible()
	{
		return $this->getRow()->getForm()->isFieldVisible($this->name);
	}

	public function isHidden()
	{
		return $this->getRow()->getForm()->isFieldHidden($this->name);
	}

	/**
	 * @return mixed
	 */
	public function getValue()
	{
		if (old($this->name) !== null) {
			return old($this->name);
		} elseif ($this->value !== null) {
			return $this->value;
		} else {
			return $this->getRow()->getForm()->getValue($this->name);
		}
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
	 * @return bool
	 */
	public function isReadonly(): bool
	{
		return $this->readonly;
	}

	/**
	 * @param bool $readonly
	 */
	public function setReadonly(bool $readonly): void
	{
		$this->readonly = $readonly;
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
	public function setPlaceholder(string $placeholder = null): Type
	{
		$this->placeholder = $placeholder;
		return $this;
	}

	public function getHelp()
	{
		return $this->help;
	}

	public function setHelp($help = null): Type
	{
		$this->help = $help;
		return $this;
	}

	public function isInvalid()
	{
		return $this->getRow()->getForm()->isFieldInvalid($this->name);
	}

	public function getError()
	{
		return $this->getRow()->getForm()->getFieldError($this->name);
	}

	public function setClass($class) : Type
	{
		$this->class = $class;
		return $this;
	}

	public function getClass()
	{
		return $this->class;
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

	public function setRows(int $rows): Type
	{
		$this->rows = $rows;
		return $this;
	}

	public function getRows()
	{
		return $this->rows;
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

	public function makeFillable()
	{
		$this->fillable = true;
	}
}
