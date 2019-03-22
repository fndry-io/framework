<?php

namespace Foundry\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class ViewComponentHandler
 *
 * @package Foundry\Facades
 * @see \Foundry\Contracts\ViewComponentHandler
 */
class ViewComponentHandler extends Facade {
	protected static function getFacadeAccessor() {
		return 'view-component-handler';
	}
}