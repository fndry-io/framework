<?php
namespace Foundry\Requests\Types\Traits;

use Foundry\Requests\Types\BaseType;

trait HasChildren {

	protected $children = [];

	/**
	 * Add children to the Type
	 *
	 * @param BaseType ...$type
	 *
	 * @return $this
	 */
	public function addChildren(BaseType &...$type)
	{
		foreach ($type as &$_type) {
			$this->children[] = $_type;
		}
		return $this;
	}

	/**
	 * Get the children for the Type
	 *
	 * @return array
	 */
	public function getChildren(): array
	{
		return $this->children;
	}

}