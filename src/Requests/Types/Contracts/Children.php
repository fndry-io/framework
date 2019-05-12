<?php

namespace Foundry\Core\Requests\Types\Contracts;

use Foundry\Core\Requests\Types\BaseType;

interface Children {

	/**
	 * Add children to the Type
	 *
	 * @param BaseType ...$types
	 *
	 * @return mixed
	 */
	public function addChildren( BaseType ...$types );

	/**
	 * Get the children for the Type
	 *
	 * @return array
	 */
	public function getChildren(): array;
}