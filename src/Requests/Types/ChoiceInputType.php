<?php

namespace Foundry\Requests\Types;

use Foundry\Requests\Types\Traits\HasMinMax;
use Foundry\Requests\Types\Traits\HasOptions;

/**
 * Class ChoiceType
 *
 * @package Foundry\Requests\Types
 * @todo Update ChoiceType and others of a similar nature to rather use traits for the additional properties and methods
 */
class ChoiceInputType extends InputType{

	use HasOptions;
	use HasMinMax;

    public function __construct(string $name,
								string $label = null,
								bool $required = true,
                                bool $expanded,
                                bool $multiple,
                                array $options,
                                $value = null,
                                string $position = 'full',
                                string $rules = null,
                                string $id = null,
                                string $placeholder = null)
    {
        $this->setMultiple($multiple);
        $this->setOptions($options);
        $this->setExpanded($expanded);
        $type = $expanded? $multiple? 'checkbox': 'radio' : 'select';

        parent::__construct($name, $label, $required, $value, $position, $rules, $id, $placeholder, $type);
    }


}
