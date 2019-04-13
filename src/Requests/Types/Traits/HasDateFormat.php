<?php

namespace Foundry\Requests\Types\Traits;

trait HasDateFormat {

	protected $format = "Y-m-d H:i:s";

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