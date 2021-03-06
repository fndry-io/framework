<?php

namespace Foundry\Models\Contracts;

interface Stateable {

	static function getStateLabels() : array;

	static function getStateLabel($key) : string;

	public function setState($state, $code);

	public function states();

	public function state();

}