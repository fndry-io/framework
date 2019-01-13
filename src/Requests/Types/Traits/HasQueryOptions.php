<?php

namespace Foundry\Requests\Types\Traits;

use Foundry\Requests\Types\Type;

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
	 * @return Type
	 */
	public function setQueryParam(string $query_param): Type
	{
		$this->query_param = $query_param;
		return $this;
	}

	/**
	 * @param $url
	 *
	 * @return Type
	 */
	public function setUrl($url) : Type
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