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

    /**
     * Serialize Object
     *
     * @return array
     */
    public function jsonSerialize()
    {
        $f = array();

        /**
         * @var $field Type
         */
        foreach ($this->fields as $field){
            array_push($f, $field->jsonSerialize());
        }

        $json = array(
            'fields' => (array) $f
        );

        return $json;
    }
}
