<?php

namespace Foundry\Requests\Types\Traits\Ajax;


trait HasAjaxCallbacks {

    /**
     * @var Callback
     * Url and methods to call on valid input value
     */
	protected $valid_ajax_callback;

    /**
     * @var Callback
     * Url and methods to call on invalid input value
     *
     */
	protected $invalid_ajax_callback;


	public function setValidAjaxCallback(string $action, string $method = null)
    {
        $this->valid_ajax_callback = new Callback($action, $method? $method: "GET");

        return $this;
    }

	public function getValidAjaxCallback()
    {
        return $this->valid_ajax_callback;
    }

    public function setInvalidAjaxCallback(string $action, string $method = null)
    {
        $this->invalid_ajax_callback = new Callback($action, $method);

        return $this;
    }

    public function getInvalidAjaxCallback()
    {
        return $this->invalid_ajax_callback;
    }
}
