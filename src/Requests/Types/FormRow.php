<?php

namespace Foundry\Requests\Types;


/**
 * Class FormRow
 *
 * @package Foundry\Requests\Types
 */
class FormRow{

    protected $fields;

    /**
     * FormRow constructor.
     *
     * @param $fields
     */
    public function __construct($fields = array())
    {
        $this->fields = $fields;
    }

    /**
     * Add a field to row
     *
     * @param Type $field
     */
    public function addField(Type $field){
        if(!in_array($field, $this->fields)){
            array_push($this->fields, $field);
        }
    }

}
