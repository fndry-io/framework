<?php

namespace Foundry\Requests\Types;

class MoneyInputType extends NumberInputType {

	protected $symbol = "$";

	public function getSymbol()
	{
		return $this->symbol;
	}

	public function setSymbol($symbol)
	{
		$this->symbol = $symbol;
		return $this;
	}

	public function display( $value = null ) {
		if ($value) {
			$value = number_format($value, 2);
		} else {
			$value = "--";
		}
		return $this->symbol . "" . $value;
	}

}