<?php

namespace Foundry\Models;

use Foundry\Requests\Types\Contracts\Inputable;
use Illuminate\Support\Collection;

class InputCollection extends Collection {

	public function rules() {
		$rules = [];
		foreach ( $this->all() as $item ) {
			$rules[ $item->getName() ] = $item->getRules();
		}

		return $rules;
	}

	public function casts() {
		$casts = [];
		foreach ( $this->all() as $item ) {
			if (method_exists($item, 'cast')) {
				$casts[ $item->getName() ] = call_user_func([$item, 'cast']);
			}

		}

		return $casts;
	}

	public function insert($key, Inputable $type)
	{
		$type->setName($key);
		$this->put($key, $type);
	}

}