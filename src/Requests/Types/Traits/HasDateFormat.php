<?php

namespace Foundry\Requests\Types\Traits;

trait HasDateFormat {

	public function getFormat()
	{
		return $this->format;
	}

	public function setFormat($format)
	{
		$this->format = $format;
		return $this;
	}

}