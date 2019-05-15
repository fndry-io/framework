<?php

namespace Foundry\Core\Inputs\Types\Contracts;


use Illuminate\Database\Eloquent\Model;

interface Inputable {

	public function getName(): string;

	public function setName(string $name);

	public function setModel( Model &$model = null );

	public function getModel(): Model;

	public function hasModel(): bool;

	public function display($value = null);

}