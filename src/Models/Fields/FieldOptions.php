<?php
namespace Foundry\Models\Fields;

use Illuminate\Database\Query\Builder;

/**
 * Interface Options
 *
 * Allows us to define the available options for a field
 *
 * @package Foundry\Models
 */
interface FieldOptions {

	/**
	 * The input options
	 *
	 * @param \Closure $closure A query builder to modify the query if needed
	 *
	 * @return array
	 */
	static function options(\Closure $closure = null): array;

}