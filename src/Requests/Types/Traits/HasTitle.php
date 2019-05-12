<?php

namespace Foundry\Core\Requests\Types\Traits;

use Foundry\Core\Requests\Types\InputType;

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
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param string $title
	 *
	 * @return InputType
	 */
	public function setTitle( string $title = null ) {
		$this->title = $title;

		return $this;
	}

}