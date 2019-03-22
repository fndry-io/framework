<?php

namespace Foundry\Requests\Types\Traits;

trait HasMask {

	protected $mask;

	public function setMask( $mask = null ) {
		$this->mask = $mask;

		return $this;
	}

	public function getMask() {
		return $this->mask;
	}
}