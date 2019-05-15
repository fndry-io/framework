<?php

namespace Foundry\Core\Inputs;

use Foundry\Core\Requests\Response;
use Foundry\Core\Support\InputTypeCollection;
use Illuminate\Support\Facades\Validator;

abstract class Inputs {

	protected $inputs = [];

	public function __construct($inputs) {
		$this->fill($inputs);
	}

	public function validate() : Response
	{
		$validator = Validator::make($this->inputs(), $this->rules());
		if ($validator->fails()) {
			return Response::error(__('Error validating request'), 422, $validator->errors());
		}
		return Response::success($validator->validated());
	}

	public function inputs()
	{
		return $this->inputs;
	}

	public function fill($params)
	{
		foreach ($params as $key => $value) {
			if (!isset($this->fillable) || in_array($key, $this->fillable)) {
				$this->inputs[$key] = $value;
			}
		}
	}

	public function isFillable($name)
	{
		if (isset($this->fillable)) {
			if ($this->fillable === true || in_array($name, $this->fillable)) {
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	}

	public function __set( $name, $value ) {
		$this->inputs[$name] = $value;
	}

	public function __get( $name ) {
		if (isset($this->inputs[$name])) {
			return $this->inputs[$name];
		} else {
			return null;
		}
	}

	abstract function types() : InputTypeCollection;
}