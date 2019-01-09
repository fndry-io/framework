<?php
namespace Foundry\Models\Fields;

/**
 * Interface Pick List Options
 *
 * Fetches a list of options from the pick lists
 *
 * @package Foundry\Models
 */
abstract class ChoiceField implements FieldOptions {

	abstract static function options(\Closure $closure = null): array;

	/**
	 * Returns the translated readable value for a given key
	 *
	 * @param $key
	 *
	 * @return mixed
	 */
	static function value($key)
	{
		$values = self::options();
		if ($values[$key]) {
			return $values[$key];
		}
		return $key;
	}

}