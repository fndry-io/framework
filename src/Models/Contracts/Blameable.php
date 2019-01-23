<?php

namespace Foundry\Models\Contracts;

use Illuminate\Support\Facades\Auth;

/**
 * Trait Blameable
 *
 * Updates the model with who created it or updated it
 *
 * @package Foundry\Models\Contracts
 */
trait Blameable {

	public static function bootBlameable()
	{
		static::saving(function($model){
			if ($user = Auth::user()) {
				$model->updated_by_user_id = $user->getKey();
			}
		});

		static::creating(function($model){
			if ($user = Auth::user()) {
				$model->created_by_user_id = $user->getKey();
			}
		});
	}
}