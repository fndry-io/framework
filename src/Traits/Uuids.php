<?php

namespace Foundry\Traits;

use Webpatser\Uuid\Uuid;

trait Uuids {

	/**
	 * Boot function from laravel.
	 */
	public static function bootUuids() {
		static::creating( function ( $model ) {
			$model->{$model->getUuidName()} = Uuid::generate()->string;
		} );
	}

	public function getUuidName()
	{
		if ($this->uuidKey) {
			return $this->uuidKey;
		} else {
			return 'uuid';
		}
	}
}
