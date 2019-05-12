<?php

namespace Foundry\Core\Facades;

use Foundry\Core\Requests\Response;
use Illuminate\Support\Facades\Facade;

/**
 * Class RequestHandler
 *
 * @package Foundry\Facades
 * @see \Foundry\Core\Contracts\FormRequestHandler
 *
 * @method Response handle($key, $request, $id = null) Handle the request
 * @method static Response view($key, $request, $id = null) Return a DocType of the Request for rendering it
 */
class FormRequestHandler extends Facade {
	protected static function getFacadeAccessor() {
		return 'form-request-handler';
	}
}