<?php

namespace Foundry\Requests\Types\Traits;

use Foundry\Requests\Types\BaseType;

trait HasChildren {

	protected $children = [];

	/**
	 * Add children to the Type
	 *
	 * @param BaseType ...$types
	 *
	 * @return $this
	 */
	public function addChildren( BaseType ...$types ) {
		foreach ( $types as $type ) {
			$this->children[] = $type;
		}

		return $this;
	}

	/**
	 * Get the children for the Type
	 *
	 * @return array
	 */
	public function getChildren(): array {
		return $this->children;
	}

}