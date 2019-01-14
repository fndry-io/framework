<?php

namespace Foundry\Requests\Types\Traits;

use Foundry\Requests\Types\InputType;

trait HasId {

	/**
	 * Input id
	 *
	 * @var string $id
	 */
	protected $id;

	/**
	 * @return string
	 */
	public function getId(): string
	{
		return $this->id;
	}

	/**
	 * @param string|null $id
	 *
	 * @return InputType
	 */
	public function setId($id = null): InputType
	{
		if ($id == null) {
			if (method_exists($this, 'getName')) {
				$this->id = camel_case(str_slug($this->getName()) . 'Type');
			} else {
				$this->id = uniqid('Id');
			}
		} else {
			$this->id = $id;
		}
		return $this;
	}

}