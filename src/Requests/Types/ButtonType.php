<?php

namespace Foundry\Requests\Types;
use Foundry\Requests\Types\Traits\HasClass;
use Foundry\Requests\Types\Traits\HasId;
use Foundry\Requests\Types\Traits\HasLabel;
use Foundry\Requests\Types\Traits\HasTitle;

/**
 * Class Type
 *
 * @package Foundry\Requests\Types
 */
class ButtonType extends BaseType {

	use HasId,
		HasLabel,
		HasClass,
		HasTitle
		;

	/**
	 * The form row this field belongs to
	 *
	 * @var FormRow $row
	 */
	protected $row;

	protected $title;

	protected $action;

	protected $method;

	protected $query;

	public function __construct(
		string $label,
		string $action,
		string $title = null,
		array $query = [],
		string $method = 'GET',
		string $id = null,
		string $type = 'action')
	{
		$this->setLabel($label);
		$this->setAction($action);
		$this->setTitle($title);
		$this->setQuery($query);
		$this->setMethod($method);
		$this->setType($type);
		$this->setId($id);
	}


	public function getAction()
	{
		return $this->action;
	}

	public function setAction(string $value): InputType
	{
		$this->action = $value;
		return $this;
	}

	public function getQuery()
	{
		return $this->query;
	}

	public function setQuery(array $value): InputType
	{
		$this->query = $value;
		return $this;
	}

	public function getMethod()
	{
		return $this->method;
	}

	public function setMethod(string $value): InputType
	{
		$this->method = $value;
		return $this;
	}


}
