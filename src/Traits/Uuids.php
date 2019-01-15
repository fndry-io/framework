<?php

namespace Foundry\Traits;

use Webpatser\Uuid\Uuid;

trait Uuids {

	/**
	 * Boot function from laravel.
	 */
	public static function bootUuids() {
		static::creating( function ( $model ) {
			$model->uuid = Uuid::generate()->string;
		} );
	}
}
