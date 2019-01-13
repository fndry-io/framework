<?php

namespace Foundry\Requests\Types;

/**
 * Class Type
 *
 * @package Foundry\Requests\Types
 */
abstract class ButtonType {

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
	 * @var string
	 */
	protected $class;

	/**
	 * The form row this field belongs to
	 *
	 * @var FormRow $row
	 */
	protected $row;

	protected $action;
	protected $title;
	protected $params;
	protected $method;

	public function __construct(string $name,
		string $label,
		string $action,
		string $title = null,
		array $params = [],
		string $method = 'GET',
		string $id = null,
		string $type = 'action')
	{
		$this->setName($name);
		$this->setLabel($label);
		$this->setAction($action);
		$this->setTitle($title);
		$this->setParams($params);
		$this->setMethod($method);
		$this->setType($type);
		$id = $id? $id: camel_case(str_slug($name.'_field'));
		$this->setId($id);
	}


	public function getAction()
	{
		return $this->action;
	}

	public function setAction(string $value): Type
	{
		$this->action = $value;
		return $this;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function setTitle(string $value): Type
	{
		$this->title = $value;
		return $this;
	}

	public function getParams()
	{
		return $this->params;
	}

	public function setParams(array $value): Type
	{
		$this->params = $value;
		return $this;
	}

	public function getMethod()
	{
		return $this->method;
	}

	public function setMethod(string $value): Type
	{
		$this->method = $value;
		return $this;
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
