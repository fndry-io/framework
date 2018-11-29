<?php

namespace Foundry\Requests\Types;


/**
 * Class NumberType
 *
 * @package Foundry\Requests\Types
 */
class NumberType extends Type{

    public function __construct(string $name,
                                string $label= null,
                                bool $required = true,
                                string $value = null,
                                string $position = 'full',
                                string $rules = null,
                                string $id = null,
                                string $placeholder = null)
    {
        $type = 'number';
        parent::__construct($name, $label, $required, $value, $position, $rules, $id, $placeholder, $type);
    }
}
