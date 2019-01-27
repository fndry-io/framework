<?php

namespace Foundry\Requests\Types\Contracts;

use Foundry\Requests\Types\InputType;
use Illuminate\Database\Eloquent\Model;

interface Modelable {

	public function setModel( Model &$model = null );

	public function getModel(): Model;

	public function attachInputs( Inputable ...$input_types );
}