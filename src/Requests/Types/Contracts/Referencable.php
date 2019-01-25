<?php

namespace Foundry\Requests\Types\Contracts;

interface Referencable {

	public function hasReference(): bool;

	public function displayRef($value = null);

}