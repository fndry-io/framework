<?php

namespace Foundry\Requests\Types\Traits;

use Foundry\Requests\Types\InputType;

trait HasQueryOptions {


	/**
	 * @var string The query param
	 */
	protected $query_param;

	/**
	 * @var string The url to query for select options and filter based on the query_param value
	 */
	protected $url;

	/**
	 * @return string
	 */
	public function getQueryParam(): string
	{
		return $this->query_param;
	}

	/**
	 * @param string $query_param
	 *
	 * @return InputType
	 */
	public function setQueryParam(string $query_param): InputType
	{
		$this->query_param = $query_param;
		return $this;
	}

	/**
	 * @param $url
	 *
	 * @return InputType
	 */
	public function setUrl($url) : InputType
	{
		$this->url = $url;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getUrl() : string
	{
		return $this->url;
	}

}