<?php

namespace Foundry\Requests\Types;


/**
 * Class FormSection
 *
 * @package Foundry\Requests\Types
 */
class FormSection{

    protected $title;

    protected $description;

    /**
     * @var array The rows
     */
    protected $rows;

    /**
     * @var FormView The wrapping form
     */
    protected $form;

    /**
     * FormSection constructor.
     *
     * @param $title
     * @param array $rows
     */
    public function __construct($title, $rows = [])
    {
        $this->title = $title;
        $this->rows = array();

        foreach ($rows as $row){
            $this->addRow($row);
        }
    }

    /**
     * Add a row to a section
     *
     * @param FormRow $row
     *
     * @return FormSection
     */
    public function addRow(FormRow $row) : FormSection
    {
        if(!in_array($row, $this->rows)){
            $row = $row->setSection($this);
            array_push($this->rows, $row);
        }

        return $this;
    }

    /**
     * Add an array of rows
     *
     * @param array $rows
     * @return FormSection
     */
    public function addFields(array $rows) : FormSection
    {
        foreach ($rows as $row){
            $this->addRow($row);
        }

        return $this;
    }

    /**
     * Get the FormView object
     *
     * @return FormView
     */
    public function getForm() : FormView
    {
        return $this->form;
    }

    /**
     * @param FormView $form
     *
     * @return FormSection
     */
    public function setForm(FormView $form): FormSection
    {
        $this->form = $form;
        return $this;
    }

    /**
     * The the rows for this section
     *
     * @return array
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
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
            'title' => $this->title,
            'description' => $this->description,
            'rows' => (array) $r,
        );

        return $json;
    }
}
