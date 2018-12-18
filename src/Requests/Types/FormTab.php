<?php

namespace Foundry\Requests\Types;


/**
 * Class FormTab
 *
 * @package Foundry\Requests\Types
 */
class FormTab{

    protected $title;

    protected $description;

    /**
     * @var array The rows
     */
    protected $rows;

    /**
     * @var array The sections
     */
    protected $sections;

    /**
     * @var FormView The wrapping form
     */
    protected $form;

    /**
     * FormTab constructor.
     *
     * @param $title
     * @param array $rows
     * @param array $sections
     */
    public function __construct($title, $rows = [], $sections = [])
    {
        $this->title = $title;
        $this->rows = array();
        $this->sections = array();

        $this->addRows($rows);
        $this->addSections($sections);
    }

    /**
     * Add a row to a tab
     *
     * @param FormRow $row
     *
     * @return FormTab
     */
    public function addRow(FormRow $row) : FormTab
    {
        if(!in_array($row, $this->rows)){
            $row = $row->setTab($this);
            array_push($this->rows, $row);
        }

        return $this;
    }

    /**
     * Add an array of rows
     *
     * @param array $rows
     * @return FormTab
     */
    public function addRows(array $rows) : FormTab
    {
        foreach ($rows as $row){
            $this->addRow($row);
        }

        return $this;
    }

    /**
     * Add a section to a tab
     *
     * @param FormSection $section
     *
     * @return FormTab
     */
    public function addSection(FormSection $section) : FormTab
    {
        if(!in_array($section, $this->sections)){
            $section = $section->setTab($this);
            array_push($this->sections, $section);
        }

        return $this;
    }

    /**
     * Add an array of sections
     *
     * @param array $sections
     * @return FormTab
     */
    public function addSections(array $sections) : FormTab
    {
        foreach ($sections as $section){
            $this->addSection($section);
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
     * @return FormTab
     */
    public function setForm(FormView $form): FormTab
    {
        $this->form = $form;
        return $this;
    }

    /**
     * The rows for this tab
     *
     * @return array
     */
    public function getRows()
    {
        $rows = $this->rows;

        /**@var $section FormSection*/
        foreach ($this->sections as $section){
            array_merge($rows, $section->getRows());
        }

        return $rows;
    }

    /**
     * The sections for this tab
     *
     * @return array
     */
    public function getSections()
    {
        return $this->sections;
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
        $s = array();

        /**
         * @var $row FormRow
         */
        foreach ($this->rows as $row){
            array_push($r, $row->jsonSerialize());
        }

        /**
         * @var $section FormSection
         */
        foreach ($this->sections as $section){
            array_push($s, $section->jsonSerialize());
        }

        $json = array(
            'title' => $this->title,
            'description' => $this->description,
            'rows' => (array) $r,
            'sections' => (array) $s
        );

        return $json;
    }
}
