<?php
namespace Foundry\Models;

use Foundry\Requests\Types\InputType;
use Illuminate\Database\Eloquent\Model;

/**
 * Interface Field
 *
 * Allows us to define the HTML input, validation rule and cast type for a field
 *
 * @package Foundry\Models
 */
interface FieldType {

	/**
	 * The input type for displaying on a page
	 *
	 * @param Model $model
	 *
	 * @return InputType
	 */
	static function input(Model $model = null) : InputType;

}