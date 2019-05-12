<?php

namespace Foundry\Core\Requests;

use Illuminate\Foundation\Http\FormRequest as LaravelFormRequest;

/**
 * Class FormRequest
 *
 * @package Foundry\Requests
 */
abstract class FormRequest extends LaravelFormRequest {

	/**
	 * The name of the Request for registering it in the FormRequest Container
	 *
	 * @return String
	 */
	abstract static function name() : String;

	/**
	 * Handle the request
	 *
	 * @param null $id The ID of the entity for the request
	 *
	 * @return Response
	 */
	abstract public function handle($id = null) : Response;

}
