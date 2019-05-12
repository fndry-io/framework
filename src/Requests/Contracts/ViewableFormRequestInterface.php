<?php

namespace Foundry\Core\Requests\Contracts;

use Foundry\Core\Requests\Types\DocType;
use Foundry\Core\Requests\Types\FormType;
use Foundry\Core\Support\InputCollection;

interface ViewableFormRequestInterface {

	/**
	 * @param null $id The ID of the entity for the request
	 *
	 * @return FormType
	 */
	static function form($id = null) : FormType;

	/**
	 * @param null $id The ID of the entity for the request
	 *
	 * @return DocType
	 */
	static function view($id = null) : DocType;

	/**
	 * The set of input classes for the request
	 *
	 * @return InputCollection
	 */
	static function inputs() : InputCollection;

}