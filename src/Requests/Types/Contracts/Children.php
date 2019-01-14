<?php

namespace Foundry\Requests\Types\Contracts;

use Foundry\Requests\Types\BaseType;

interface Children {

	/**
	 * Add children to the Type
	 *
	 * @param BaseType ...$type
	 *
	 * @return mixed
	 */
	public function addChildren(BaseType &...$type);

	/**
	 * Get the children for the Type
	 *
	 * @return array
	 */
	public function getChildren(): array;
}