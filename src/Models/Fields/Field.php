<?php
namespace Foundry\Models\Fields;

use Foundry\Requests\Types\InputType;
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
	 * @return InputType
	 */
	static function input() : InputType;

}