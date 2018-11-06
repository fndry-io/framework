<?php

namespace Foundry\Requests\Types;


/**
 * Class FormView
 *
 * @package Foundry\Requests\Types
 */
class FormView{

    protected $rows;

    /**
     * FormView constructor.
     *
     * @param $rows
     */
    public function __construct($rows = array())
    {
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
}
