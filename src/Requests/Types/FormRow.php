<?php

namespace Foundry\Requests\Types;


/**
 * Class FormRow
 *
 * @package Foundry\Requests\Types
 */
class FormRow{

	/**
	 * @var array The fields
	 */
    protected $fields;

    protected $section;

    protected $tab;

    /**
     * @var array the forms
     */
    protected $forms;

	/**
	 * @var FormView The wrapping form
	 */
    protected $form;

    /**
     * FormRow constructor.
     *
     * @param $fields
     */
    public function __construct($fields = [])
    {
        $this->fields = array();
        $this->forms = array();

        foreach ($fields as $field){
            $this->addField($field);
        }
    }

    /**
     * Add a field to row
     *
     * @param Type $field
     *
     * @return FormRow
     */
    public function addField(Type $field) : FormRow
    {
        if(!in_array($field, $this->fields)){
            $field->setRow($this);
            array_push($this->fields, $field);
        }

        return $this;
    }

    /**
     * Add an array of fields
     *
     * @param array $fields
     * @return FormRow
     */
    public function addFields(array $fields) : FormRow
    {
        foreach ($fields as $field){
            $this->addField($field);
        }

        return $this;
    }

    /**
     * Add an inner form
     *
     * @param FormView $formView
     * @return FormRow
     */
    public function addForm(FormView $formView) : FormRow
    {
        if(!in_array($formView, $this->forms)){
            array_push($this->forms, $formView);
        }

        return $this;
    }

    /**
     * Add multiple inner forms
     *
     * @param array $forms
     * @return FormRow
     */
    public function addForms(array $forms): FormRow
    {
        foreach ($forms as $form){
            $this->addForm($form);
        }

        return $this;
    }

	/**
	 * Get the field by its name
	 *
	 * @param $name
	 *
	 * @return Type|null
	 */
    public function getField($name)
    {
	    /**
	     * @var Type $field
	     */
    	foreach ($this->fields as $field) {
    		if ($field->getName() === $name) {
    			return $field;
		    }
	    }
	    return null;
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
     * @return mixed
     */
    public function getTab()
    {
        return $this->tab;
    }

    /**
     * @param mixed $tab
     *
     * @return FormRow
     */
    public function setTab($tab): FormRow
    {
        $this->tab = $tab;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * @param mixed $section
     *
     * @return FormRow
     */
    public function setSection(FormSection $section): FormRow
    {
        $this->section = $section;

        return $this;
    }

    /**
     * @param FormView $form
     *
     * @return FormRow
     */
    public function setForm(FormView $form): FormRow
    {
        $this->form = $form;
        return $this;
    }

	/**
	 * The the fields for this row
	 *
	 * @return array
	 */
	public function getFields()
	{
		return $this->fields;
	}

    /**
     * @return array
     */
    public function getForms(): array
    {
        return $this->forms;
    }

    /**
     * @param array $forms
     */
    public function setForms(array $forms): void
    {
        foreach ($forms as $form){
            $this->addForm($form);
        }
    }

	/**
	 * Return the number of fields in this row
	 *
	 * @return int
	 */
	public function fieldCount(): int
	{
		return count($this->fields);
	}

	/**
     * Serialize Object
     *
     * @return array
     */
    public function jsonSerialize()
    {
        $f = array();
        $forms = array();

        /**
         * @var $field Type
         */
        foreach ($this->fields as $field){
            array_push($f, $field->jsonSerialize());
        }

        /**@var $form FormView $form */
        foreach ($this->forms as $form){
            array_push($forms, $form->jsonSerialize());
        }

        $json = array(
            'fields' => (array) $f,
            'forms' => (array) $forms
        );

        return $json;
    }
}
