<?php
namespace Foundry\Models\Fields;

use Foundry\Requests\Types\Type;
use Illuminate\Database\Eloquent\Model;

/**
 * Interface Field
 *
 * Allows us to define the HTML input, validation rule and cast type for a field
 *
 * @package Foundry\Models
 */
interface Field {

	/**
	 * The input type for displaying on a page
	 *
	 * @return Type
	 */
	static function input() : Type;

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