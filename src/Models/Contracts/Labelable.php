<?php

namespace Foundry\Core\Models\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface Labelable {

	public function getLabelAttribute();

	/**
	 * Return a Query build for the current model with the label fields pre added to the select so that getLabelAttribute will work
	 *
	 * @return Builder
	 */
	static function queryWithLabel() : Builder;

}