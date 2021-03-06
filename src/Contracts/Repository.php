<?php

namespace Foundry\Contracts;


interface Repository {
	/**
	 * Determine if the given key value exists.
	 *
	 * @param  string $key
	 *
	 * @return bool
	 */
	public function has( $key );

	/**
	 * Get the specified key value.
	 *
	 * @param  array|string $key
	 * @param  mixed $default
	 *
	 * @return mixed
	 */
	public function get( $key, $default = null );

	/**
	 * Get all of the items for the given repo.
	 *
	 * @return array
	 */
	public function all();

	/**
	 * Set a given key value.
	 *
	 * @param  array|string $key
	 * @param  mixed $value
	 *
	 * @return void
	 */
	public function set( $key, $value = null );
}
