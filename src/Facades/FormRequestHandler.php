<?php

namespace Foundry\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class RequestHandler
 *
 * @package Foundry\Facades
 * @see \Foundry\Contracts\FormRequestHandler
 */
class FormRequestHandler extends Facade {
	protected static function getFacadeAccessor() {
		return 'form-request-handler';
	}
}