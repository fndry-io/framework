<?php

namespace Foundry\Core\Requests\Types;

use Foundry\Core\Requests\Types\Contracts\Children;
use Foundry\Core\Requests\Types\Traits\HasChildren;

abstract class ParentType extends BaseType implements Children {

	use HasChildren;
}