<?php
namespace Foundry\Requests\Types;

use Foundry\Requests\Types\Contracts\Children;
use Foundry\Requests\Types\Traits\HasChildren;

abstract class ParentType extends BaseType implements Children {

	use HasChildren;
}