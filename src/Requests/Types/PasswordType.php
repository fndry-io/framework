<?php

namespace Foundry\Requests\Types;


/**
 * Class PasswordType
 *
 * @package Foundry\Requests\Types
 */
class PasswordType extends Type{

    public function __construct(string $name,
                                string $label = '',
                                bool $required = true,
                                string $value = '',
                                string $position = 'full',
                                string $rules = '',
                                string $id = '',
                                string $placeholder = '')
    {
        $type = 'password';
        parent::__construct($name, $label, $required, $value, $position, $rules, $id, $placeholder, $type);
    }
}
