<?php

namespace Foundry\Requests\Types;

use Foundry\Requests\Types\Contracts\Modelable;
use Foundry\Requests\Types\Traits\HasButtons;
use Foundry\Requests\Types\Traits\HasClass;
use Foundry\Requests\Types\Traits\HasErrors;
use Foundry\Requests\Types\Traits\HasId;
use Foundry\Requests\Types\Traits\HasName;
use Foundry\Requests\Types\Traits\HasRules;
use Illuminate\Database\Eloquent\Model;


/**
 * Class FormRow
 *
 * @package Foundry\Requests\Types
 */
class FormType extends ParentType implements Modelable {

	use HasName,
		HasClass,
		HasId,
		HasButtons,
		HasErrors,
		HasRules
		;

	protected $action;

	protected $method;

	protected $encoding;

	/**
	 * @var Model
	 */
	protected $model;

	/**
	 * @var InputType[]
	 */
	protected $inputs;

	/**
	 * FormType constructor.
	 *
	 * @param $name
	 * @param $action
	 * @param null $method
	 * @param null $encoding
	 * @param null $id
	 */
    public function __construct($name, $action, $method = null, $encoding = null, $id = null)
    {
    	$this->setType('form');
    	$this->setName($name);
	    $this->setAction($action);
	    $this->setMethod($method);
	    $this->setEncoding($encoding);
	    $this->setId($id);
    }

    public function setAction(string $value): FormType
    {
    	$this->action = $value;
    	return $this;
    }
	public function getAction()
	{
    	return $this->action;
	}

	public function setMethod(string $value): FormType
	{
		$this->action = $value;
		return $this;
	}
	public function getMethod()
	{
    	$this->method;
	}

	public function setEncoding($value): FormType
	{
		$this->action = $value;
		return $this;
	}
	public function getEncoding()
	{
    	$this->encoding;
	}

	public function setModel(Model &$model): FormType
	{
		$this->model = $model;
		return $this;
	}
	public function getModel() : Model
	{
		$this->model;
	}

	public function attachInputs(InputType &...$inputs)
	{
		if ($this->model) {
			foreach ($inputs as &$input) {
				if (!$input->hasModel()) {
					/**
					 * @var InputType $input
					 */
					$input->setModel($this->model);
				}
			}
		}
		$this->inputs[] = $inputs;
		return $this;
	}

	public function getInputs()
	{
		return $this->inputs;
	}

	/**
	 * Get the attached input
	 *
	 * @param $name
	 *
	 * @return InputType|null
	 */
	public function getInput($name)
	{
		foreach ($this->inputs as &$input) {
			if ($name === $input->getName()) {
				return $input;
			}
		}
		return null;
	}

	/**
	 * Is the input visible
	 *
	 * @param $key
	 *
	 * @return bool
	 */
	public function isInputVisible($key)
	{
		if ($input = $this->getInput($key)) {
			/**
			 * @var InputType $input
			 */
			if ($input->hasModel()) {
				$hidden = $input->getModel()->getHidden();
				$visible = $input->getModel()->getVisible();
				if (!in_array($input->getName(), $hidden) && in_array($input->getName(), $visible)) {
					return true;
				} elseif (in_array($input->getName(), $hidden)) {
					return false;
				}
			}
		}
		return true;
	}

	/**
	 * Is the input hidden
	 *
	 * @param $key
	 *
	 * @return bool
	 */
	public function isInputHidden($key)
	{
		if ($input = $this->getInput($key)) {
			/**
			 * @var InputType $input
			 */
			if ($input->hasModel()) {
				$hidden = $input->getModel()->getHidden();
				if (in_array($input->getName(), $hidden)) {
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * Is input Guarded
	 *
	 * @param $key
	 *
	 * @return bool
	 */
	public function isInputGuarded($key)
	{
		if ($input = $this->getInput($key)) {
			/**
			 * @var InputType $input
			 */
			if ($input->hasModel()) {
				return $input->getModel()->isGuarded($input->getName());
			}
		}
		return false;
	}

	/**
	 * Is input fillable
	 *
	 * @param $key
	 *
	 * @return bool
	 */
	public function isInputFillable($key)
	{
		if ($input = $this->getInput($key)) {
			/**
			 * @var InputType $input
			 */
			if ($input->hasModel()) {
				return $input->getModel()->isFillable($input->getName());
			}
		}
		return true;
	}

	/**
	 * Get the value for a given key on the model
	 *
	 * @param $key
	 *
	 * @return mixed|null
	 */
	public function getValue($key)
	{
		if ($this->model) {
			return object_get($this->model,  $key);
		}
		return null;
	}

	/**
	 * Set values
	 *
	 * @param $values
	 * @return $this
	 */
	public function setValues($values)
	{
		foreach ($values as $name => $value) {
			if ($input = $this->getInput($name)) {
				/**@var InputType $input*/
				$input->setValue($value);
			}
		}
		return $this;
	}

	/**
	 * Create a row and add inputs to it
	 *
	 * @param InputType[] $types The inputs to add
	 *
	 * @return $this
	 */
	public function addInputRow(InputType &...$types)
	{
		$this->addChildren((new RowType())->addChildren($types));
		return $this;
	}

	/**
	 * Get the errors for the invalid input
	 *
	 * @param $key
	 *
	 * @return array|null
	 */
	public function getInputError($key)
	{
		if ($input = $this->getInput($key)) {
			if ($input->hasErrors()) {
				return $input->getErrors();
			}
		}
		return null;
	}

	/**
	 * Determine if a input is invalid
	 *
	 * @param $key
	 *
	 * @return bool
	 */
	public function isInputInvalid($key)
	{
		if ($input = $this->getInput($key)) {
			return $input->hasErrors();
		}
		return null;
	}

	/**
	 * Return the number of inputs in this form
	 *
	 * @return int
	 */
	public function inputCount(): int
	{
		return count($this->inputs);
	}


	/**
	 * Sets the rules for the form and its inputs
	 *
	 * @param $rules
	 *
	 * @return $this
	 */
	public function setRules($rules)
	{
		$this->rules = $rules;
		foreach ($this->rules as $key => $rules) {
			if ($input = $this->getInput($key)) {
				/**@var InputType $input*/
				$input->setRules($rules);
			}
		}
		return $this;
	}

	/**
	 * Set the request
	 *
	 * @param $request
	 *
	 * @return $this
	 */
	public function setRequest($request)
	{
		$this->request = $request;
		if ($request->session()->has('errors') && $request->session()->get('errors')->hasBag('default')) {
			$this->setErrors($request->session()->get('errors')->getBag('default'));
		}
		return $this;
	}

}
