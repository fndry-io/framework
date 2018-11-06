<?php

namespace Foundry\Requests\Types;


/**
 * Class EmailType
 *
 * @package Foundry\Requests\Types
 */
class EmailType extends Type{

    public function __construct(string $name,
                                string $label = '',
                                bool $required = true,
                                string $value = '',
                                string $position = 'full',
                                string $rules = '',
                                string $id = '',
                                string $placeholder = '')
    {
        $type = 'email';
        parent::__construct($name, $label, $required, $value, $position, $rules, $id, $placeholder, $type);
    }
}
