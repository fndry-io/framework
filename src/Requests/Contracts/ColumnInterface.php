<?php

namespace Foundry\Requests\Contracts;

use Foundry\Models\InputCollection;

interface ColumnInterface {

	public static function columns(): InputCollection;
}