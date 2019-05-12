<?php

namespace Foundry\Core\Requests\Types\Contracts;

use Foundry\Core\Requests\Types\InputType;
use Illuminate\Database\Eloquent\Model;

interface Modelable {

	public function setModel( Model &$model = null );

	public function getModel(): Model;

	public function attachInputs( Inputable ...$input_types );
}