<?php
namespace Foundry\Models;

use Illuminate\Support\Collection;

class InputCollection extends Collection {

	public function rules()
	{
		$rules = [];
		foreach($this->all() as $item) {
			$rules[$item->getName()] = $item->getRules();
		}
	}

}