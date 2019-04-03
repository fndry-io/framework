<?php

namespace Foundry\Models\Traits;

trait HasState {

	static function getStateLabel($key) : string
	{
		return static::getStateLabels()[$key];
	}

	public function setState($state_id) {
		$this->state_id = $state_id;
		$this->save();
	}

	public function setToStateCode($code, $message = null)
	{
		$class = config('foundry.state.model');
		$state = new $class();
		$state->code = $code;
		$state->message = $message;
		$state->stateable()->associate($this);
		$state->save();
		return $state;
	}

}