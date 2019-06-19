<?php

namespace Foundry\Models\Traits;

trait HasState {

	static function getStateLabel($key) : string
	{
		return static::getStateLabels()[$key];
	}

	public function setState($state_id,  $code) {
		$this->state_id = $state_id;
		$this->state_code = $code;
		$this->save();
	}

	public function setToStateCode($code, $comment = null)
	{
		$class = config('foundry.state.model');
		$state = new $class();
		$state->code = $code;
		$state->comment = $comment;
		$state->stateable()->associate($this);
		$state->save();
		return $state;
	}

}