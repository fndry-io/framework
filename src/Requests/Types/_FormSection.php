<?php

namespace Foundry\Requests\Types;
use Foundry\Requests\Types\Traits\HasDescription;
use Foundry\Requests\Types\Traits\HasTitle;


/**
 * Class FormSection
 *
 * @package Foundry\Requests\Types
 */
class _FormSection {

	use HasTitle,
		HasDescription
		;

    protected $tab;

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
     * @return mixed
     */
    public function getTab()
    {
        return $this->tab;
    }

    /**
     * @param mixed $tab
     *
     * @return $this
     */
    public function setTab($tab)
    {
        $this->tab = $tab;

        return $this;
    }

    /**
     * Add an array of rows
     *
     * @param array $rows
     * @return $this
     */
    public function addRows(array $rows)
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
    public function getForm()
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
