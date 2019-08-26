<?php

namespace Foundry\Requests\Types\Traits\Ajax;


class Callback {

	protected $action;
	protected $method = 'GET';

    public function __construct($action, $method = 'GET')
    {
        $this->action = $action;
        $this->method = $method;
    }

    public function getAction() {
		return $this->action;
	}

	public function setAction( string $value = null ) {
		$this->action = $value;

		return $this;
	}

	public function getMethod() {
		return $this->method;
	}

	public function setMethod( string $value = null ) {
		$this->method = $value;

		return $this;
	}

	public function toArray()
    {
        return [
           'action' => $this->action,
           'method' => $this->method
        ];
    }

}
