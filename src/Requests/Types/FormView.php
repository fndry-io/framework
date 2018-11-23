<?php

namespace Foundry\Requests\Types;


use Illuminate\Database\Eloquent\Model;

/**
 * Class FormView
 *
 * @package Foundry\Requests\Types
 */
class FormView{

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

    protected $action;

    protected $method;

    protected $submit;

    protected $links;

    protected $submitClass;

    /**
     * Form POST url
     * @var string
     */
    protected $postUrl;

    /**
     * Form PUT url
     * @var string
     */
    protected $putUrl;

    /**
     * Form DELETE url
     * @var string
     */
    protected $deleteUrl;

    /**
     * @var Model $model
     */
    protected $model;

	/**
	 * form rows
	 * @var array
	 */
	protected $rows;

	/**
	 * @var array
	 */
	protected $errors;
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
        return $this;
    }

    public function setSubmit($submit): FormView
    {
    	$this->submit = $submit;
    	return $this;
    }

	public function getSubmit($submit): FormView
	{
		return $this->submit;
	}

	public function setSubmitClass($class): FormView
	{
		$this->submitClass = $class;
		return $this;
	}

	public function getSubmitClass($class): FormView
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

	public function setErrors($errors): FormView
	{
		$this->errors = $errors;
		return $this;
	}

	public function getFieldError($field)
	{
		if (!empty($this->errors) && isset($this->errors[$field])) {
			return $this->errors[$field];
		}
		 return null;
	}

	public function isFieldInvalid($field)
	{
		return (!empty($this->errors) && isset($this->errors[$field]));
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
	    if ($this->errors) $json['errors'] = $this->errors;
	    if ($this->submit) $json['submit'] = $this->submit;
	    if ($this->links)  $json['links'] = $this->links;

        return $json;
    }
}
