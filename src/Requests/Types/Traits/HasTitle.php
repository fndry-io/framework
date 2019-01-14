<?php

namespace Foundry\Requests\Types\Traits;

use Foundry\Requests\Types\InputType;

trait HasTitle {

	/**
	 * Title
	 *
	 * @var string $title
	 */
	protected $title;

	/**
	 * @return string
	 */
	public function getTitle(): string
	{
		return $this->title;
	}

	/**
	 * @param string $title
	 *
	 * @return InputType
	 */
	public function setTitle(string $title): InputType
	{
		$this->title = $title;

		return $this;
	}

}