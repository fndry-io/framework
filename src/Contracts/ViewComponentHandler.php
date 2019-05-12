<?php

namespace Foundry\Core\Contracts;

use Foundry\Core\Requests\FormRequest;
use Foundry\Core\Requests\Response;
use Foundry\Core\View\Components\ViewComponent;
use Illuminate\View\View;

interface ViewComponentHandler {

	/**
	 * Register a view component request class
	 *
	 * @param ViewComponent $class
	 */
	public function register( $class );

	/**
	 * Handle the requested view component with the request
	 *
	 * @param $name
	 * @param $request
	 *
	 * @return View
	 */
	public function handle( $name, $request ): View;

}