<?php

namespace Foundry\Core\Inputs\Types\Contracts;

use Foundry\System\Entities\Entity;

interface Entityable {

	public function setEntity( Entity &$entity = null );

	public function getEntity(): Entity;

	public function attachInputs( Inputable ...$input_types );
}