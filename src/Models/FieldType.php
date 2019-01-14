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
	 * @return InputType
	 */
	static function input() : InputType;

	/**
	 * The rule for validation
	 *
	 * @param Model|null $model
	 *
	 * @return mixed
	 */
	static function rules(Model $model = null) : array;

	/**
	 * The PHP type of a field
	 *
	 * @see http://php.net/manual/en/function.settype.php
	 * @return string
	 */
	static function type() : string;

}