<?php

namespace Foundry\Requests\Types\Traits;

use Foundry\Requests\Types\Type;

trait HasRequest {

	/**
	 * The form request details
	 *
	 * array['url'] string The url route to call
	 * array['request'] string The request name. Maps to _request query param.
	 * array['id'] int The request model id. Maps to _id query param.
	 *
	 * @var array The array
	 */
	protected $form_request;

	/**
	 * Sets the
	 *
	 * @param $url
	 * @param $name
	 * @param null $id
	 *
	 * @return Type
	 */
	public function setFormRequest($url, $name, $id = null) : Type
	{
		$this->form_request = [
			'url' => $url,
			'name' => $name,
			'id' => $id
		];
		return $this;
	}

	public function getFormRequest(): array
	{
		return $this->form_request;
	}

}