<?php

namespace Foundry\Requests\Types;


/**
 * Class FormView
 *
 * @package Foundry\Requests\Types
 */
class FormView{

    protected $rows;
    protected $name;

    /**
     * FormView constructor.
     *
     * @param $name
     * @param array $rows
     */
    public function __construct($name, $rows = array())
    {
        $this->name = $name;
        $this->rows = $rows;
    }


    /**
     * Add a form row
     *
     * @param FormRow $row
     */
    public function addRow(FormRow $row)
    {
        if(!in_array($row, $this->rows)){
            array_push($this->rows, $row);
        }

    }

    /**
     * Serialize Object
     *
     * @return array
     */
    public function jsonSerialize()
    {
        $r = array();

        /**
         * @var $row FormRow
         */
        foreach ($this->rows as $row){
            array_push($r, $row->jsonSerialize());
        }

        $json = array(
            'name' => $this->name,
            'rows' => (array) $r
        );

        return $json;
    }
}
