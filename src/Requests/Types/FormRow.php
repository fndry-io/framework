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
        $this->fields = $fields;
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
