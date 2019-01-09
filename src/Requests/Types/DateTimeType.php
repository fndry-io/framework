<?php

namespace Foundry\Requests\Types;


/**
 * Class DateTimeType
 *
 * @package Foundry\Requests\Types
 */
class DateTimeType extends Type {

    public function __construct(string $name,
                                string $label = null,
                                bool $required = true,
                                string $value = null,
                                string $position = 'full',
                                string $rules = null,
                                string $id = null,
                                string $placeholder = null)
    {
        $type = 'datetime';
        parent::__construct($name, $label, $required, $value, $position, $rules, $id, $placeholder, $type);
    }
}
