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


}