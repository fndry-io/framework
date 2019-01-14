<?php

namespace Foundry\Requests\Types\Traits;

use Foundry\Requests\Types\InputType;
use Illuminate\Database\Eloquent\Model;

trait HasValue {


	/**
	 * Value
	 *
	 * @var mixed $value
	 */
	protected $value = null;

	protected $fillable;

	/**
	 * @return string
	 */
	public function getValue(): string
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
	 * @return InputType
	 */
	public function setValue($value): InputType
	{
		$this->value = $value;

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

	public function isInvalid()
	{
		return $this->getRow()->getForm()->isFieldInvalid($this->name);
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