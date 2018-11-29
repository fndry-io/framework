<?php

namespace Foundry\Requests\Types;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\MessageBag as MessageBagContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\View;
use Illuminate\Support\MessageBag;

/**
 * Class FormView
 *
 * @package Foundry\Requests\Types
 */
class FormView implements Arrayable {


    /**
     * form name
     * @var string
     */
    protected $name;

	/**
	 * form id
	 * @var string
	 */
    protected $id;

	/**
	 * @var string The form action url
	 */
    protected $action;

	/**
	 * @var string The form method POST, GET
	 */
    protected $method;

	/**
	 * @var string The submit button text
	 */
    protected $submit;

	/**
	 * @var string The submit button class
	 */
	protected $submitClass;

	/**
	 * @var array Any links for the form which should be displayed with the submit button
	 */
    protected $links;

    /**
     * @var string Form POST url
     */
    protected $postUrl;

    /**
     * @var string Form PUT url
     */
    protected $putUrl;

    /**
     * @var string Form DELETE url
     */
    protected $deleteUrl;

    /**
     * @var Model The associated model for the form view
     */
    protected $model;

	/**
	 * form rows
	 * @var array
	 */
	protected $rows;

	/**
	 * @var MessageBag
	 */
	protected $errors;

	/**
	 * @var string The view to render this Form View
	 */
	protected $view;

	/**
	 * @var array The rules to be applied
	 */
	protected $rules;

	/**
     * FormView constructor.
     *
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
        $this->rows = array();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return FormView
     */
    public function setName($name): FormView
    {
        $this->name = $name;

        return $this;
    }

	/**
	 * @return string
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param string $id
	 *
	 * @return FormView
	 */
	public function setId($id): FormView
	{
		$this->id = $id;
		return $this;
	}

	public function setAction($action): FormView
	{
		$this->action = $action;
		return $this;
	}

	public function getAction()
	{
		return $this->action;
	}

	public function setMethod($method): FormView
	{
		$this->method = $method;
		return $this;
	}

	public function getMethod()
	{
		return $this->method;
	}

	/**
     * @return string
     */
    public function getPostUrl()
    {
        return $this->postUrl;
    }

    /**
     * @param string $postUrl
     *
     * @return FormView
     */
    public function setPostUrl($postUrl) : FormView
    {
        $this->postUrl = $postUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getPutUrl()
    {
        return $this->putUrl;
    }

    /**
     * @param string $putUrl
     *
     * @return FormView
     */
    public function setPutUrl($putUrl) : FormView
    {
        $this->putUrl = $putUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getDeleteUrl()
    {
        return $this->deleteUrl;
    }

    /**
     * @param string $deleteUrl
     *
     * @return FormView
     */
    public function setDeleteUrl($deleteUrl) : FormView
    {
        $this->deleteUrl = $deleteUrl;

        return $this;
    }

    /**
     * @param string $postUrl
     * @param string $putUrl
     * @param string $deleteUrl
     *
     * @return FormView
     */
    public function setFormUrls($postUrl = '', $putUrl = '', $deleteUrl = '') : FormView
    {
        $this->setPostUrl($postUrl);
        $this->setPutUrl($putUrl);
        $this->setDeleteUrl($deleteUrl);

        return $this;
    }

    /**
     * Add a form row
     *
     * @param FormRow $row
     *
     * @return FormView
     */
    public function addRow(FormRow $row) : FormView
    {
        if(!in_array($row, $this->rows)){
            $row->setForm($this);
            array_push($this->rows, $row);
        }

        return $this;
    }

    public function getRows()
    {
    	return $this->rows;
    }

    public function setValues($values) : FormView
    {
	    /**
	     * @var FormRow $row
	     */
	    foreach ($this->getRows() as &$row) {
	    	foreach ($row->getFields() as &$field) {
	    		$name = $field->getName();
	    		if (isset($values[$name])) {
				    $field->setValue($values[$name]);
			    }
		    }
	    }
	    return $this;
    }

	public function getField($name)
	{
		/**
		 * @var FormRow $row
		 */
		foreach ($this->rows as $row) {
			if ($field = $row->getField($name)) {
				return $field;
			}
		}
		return null;
	}

	/**
     * @return null | Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param Model $model
     *
     * @return FormView
     */
    public function setModel(Model $model): FormView
    {
        $this->model = $model;
        $this->setValues($model->toArray());
        return $this;
    }

    public function isFieldVisible($key)
    {
    	if ($this->model) {
		    $hidden = $this->model->getHidden();
    		$visible = $this->model->getVisible();
    		if (!in_array($key, $hidden) && in_array($key, $visible)) {
    			return true;
		    } elseif (in_array($key, $hidden)) {
    			return false;
		    }
	    }
	    return true;
    }

    public function isFieldHidden($key)
    {
	    return ($this->model && in_array($key, $this->model->getHidden()));
    }

	public function isFieldGuarded($key)
	{
		if ($this->model) {
			return $this->model->isGuarded($key);
		}
		return false;
	}

	public function isFieldFillable($key)
	{
		if ($this->model) {
			return $this->model->isFillable($key);
		}
		return true;
	}

	public function getValue($key)
    {
    	if ($this->model) {
    		return $this->model->getAttribute($key);
	    }
	    return null;
    }

    public function setSubmit($submit): FormView
    {
    	$this->submit = $submit;
    	return $this;
    }

	public function getSubmit()
	{
		return $this->submit;
	}

	public function setSubmitClass($class): FormView
	{
		$this->submitClass = $class;
		return $this;
	}

	public function getSubmitClass()
	{
		return $this->submitClass;
	}

	public function addLink($url, $label): FormView
	{
		$this->links[] = ['url' => $url, 'label' => $label];
		return $this;
	}

	public function getLinks()
	{
		return $this->links;
	}

	public function hasLinks()
	{
		return !empty($this->links);
	}

	/**
	 * Set the errors
	 *
	 * @param MessageBagContract|array $errors
	 *
	 * @return FormView
	 */
	public function setErrors($errors): FormView
	{
		if (is_array($errors)) {
			$errors = new MessageBag($errors);
		}
		$this->errors = $errors;
		return $this;
	}

	/**
	 * Get the errors
	 *
	 * @return MessageBagContract
	 */
	public function getErrors(): MessageBagContract
	{
		return ($this->errors) ? $this->errors : new MessageBag();
	}

	/**
	 * Get the errors for the invalid field
	 *
	 * @param $field
	 *
	 * @return array|null
	 */
	public function getFieldError($field)
	{
		if ($this->isFieldInvalid($field)) {
			return $this->errors->get($field);
		}
		return null;
	}

	/**
	 * Determine if a field is invalid
	 *
	 * @param $field
	 *
	 * @return bool
	 */
	public function isFieldInvalid($field)
	{
		return ($this->errors && $this->errors->has($field));
	}

	public function getRule($key)
	{
		if (isset($this->rules[$key])) {
			return $this->rules[$key];
		}
		return null;
	}

	public function getRules()
	{
		return $this->rules();
	}

	public function setRules($rules): FormView
	{
		$this->rules = $rules;
		return $this;
	}

	/**
	 * Return the number of fields in this form
	 *
	 * @return int
	 */
	public function fieldCount(): int
	{
		$count = 0;
		foreach ($this->getRows() as $row) {
			$count = $count + $row->fieldCount();
		}
		return $count;
	}

	/**
	 * Set the view
	 *
	 * @param $view
	 *
	 * @return $this
	 */
	public function setView($view)
	{
		$this->view = $view;
		return $this;
	}

	/**
	 * Render the view for the form
	 *
	 * @return \Illuminate\Contracts\View\View
	 */
	public function view()
	{
		return view($this->view, [
			'form' => $this
		]);
	}

	/**
	 * Set the request
	 *
	 * @param $request
	 *
	 * @return $this
	 */
	public function setRequest($request)
	{
		$this->request = $request;
		if ($request->session()->has('errors') && $request->session()->get('errors')->hasBag('default')) {
			$this->setErrors($request->session()->get('errors')->getBag('default'));
		}
		return $this;
	}

	/**
     * Serialize Object
     *
     * @return array
     */
    public function jsonSerialize()
    {
        $r = array();
        $u = array();

        if ($this->getPostUrl())
            $u['POST'] = $this->getPostUrl();

        if($this->getPutUrl())
            $u['PUT'] = $this->getPutUrl();

        if($this->getDeleteUrl())
            $u['DELETE'] = $this->getDeleteUrl();

        /**
         * @var $row FormRow
         */
        foreach ($this->rows as $row){
            array_push($r, $row->jsonSerialize());
        }

        $json = array(
	        'id' => $this->id,
            'name' => $this->name,
            'rows' => (array) $r
        );

        if ($u) $json['methods'] = (array) $u;
	    if ($this->action) $json['action'] = $this->action;
	    if ($this->method) $json['method'] = $this->method;
	    if ($this->errors) $json['errors'] = $this->errors->toArray();
	    if ($this->submit) $json['submit'] = $this->submit;
	    if ($this->links)  $json['links'] = $this->links;

        return $json;
    }

    public function toArray()
    {
    	return $this->jsonSerialize();
    }
}
