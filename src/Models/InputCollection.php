<?php

namespace Foundry\Core\Models;

use Foundry\Core\Requests\Types\Contracts\Inputable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class InputCollection extends Collection {

	public function rules() {
		$rules = [];
		foreach ( $this->all() as $item ) {
			if ($item->getType() === 'checkbox' && $item->isMultiple()) {
				if ($item->isRequired()) {
					$rules[ $item->getName() ] = 'array';
				}
				$rules[ $item->getName() . '.*' ] = $item->getRules();
			} else {
				$rules[ $item->getName() ] = $item->getRules();
			}

		}

		return $rules;
	}

	public function setModel(Model &$model)
	{
		foreach ($this->items as $item) {
			/**
			 * @var Inputable $item
			 */
			$item->setModel($model);
		}
		return $this;
	}

	public function casts() {
		$casts = [];
		foreach ( $this->all() as $item ) {
			if (method_exists($item, 'cast')) {
				$casts[ $item->getName() ] = call_user_func([$item, 'cast'], $item);
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