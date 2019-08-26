<?php

namespace Foundry\Requests\Types\Traits\Ajax;


trait HasAjaxCallbacks {

    /**
     * @var Callback
     * Url and methods to call on valid input value
     */
	protected $valid;

    /**
     * @var Callback
     * Url and methods to call on invalid input value
     *
     */
	protected $invalid;


	public function setValidCallback(string $action, string $method = null)
    {
        $this->valid = new Callback($action, $method);
    }

	public function getValidCallback()
    {
        return $this->valid;
    }

    public function setInvalidCallback(string $action, string $method = null)
    {
        $this->invalid = new Callback($action, $method);
    }

    public function getInvalidCallback()
    {
        return $this->invalid;
    }
}
