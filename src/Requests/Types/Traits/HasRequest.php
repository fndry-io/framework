<?php

namespace Foundry\Requests\Types\Traits;

use Foundry\Requests\Types\InputType;

trait HasRequest {

	protected $request_url;
	protected $request_name;
	protected $request_id = null;


	public function setRequestUrl($url) : InputType
	{
		$this->request_url = $url;
		return $this;
	}

	public function setRequestName($name) : InputType
	{
		$this->request_name = $name;
		return $this;
	}

	public function setRequestId($id) : InputType
	{
		$this->request_id = $id;
		return $this;
	}

	public function getRequestUrl() : string
	{
		return $this->request_url;
	}

	public function getRequestName() : string
	{
		return $this->request_name;
	}

	public function getRequestId()
	{
		return $this->request_id;
	}

}