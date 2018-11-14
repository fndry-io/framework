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
     * form rows
     * @var array
     */
    protected $rows;
    /**
     * form name
     * @var string
     */
    protected $name;
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
     * FormView constructor.
     *
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
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
     */
    public function setName($name)
    {
        $this->name = $name;
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
     */
    public function setPostUrl($postUrl)
    {
        $this->postUrl = $postUrl;
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
     */
    public function setPutUrl($putUrl)
    {
        $this->putUrl = $putUrl;
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
     */
    public function setDeleteUrl($deleteUrl)
    {
        $this->deleteUrl = $deleteUrl;
    }

    public function setFormUrls($postUrl = '', $putUrl = '', $deleteUrl = '')
    {
        $this->setPostUrl($postUrl);
        $this->setPutUrl($putUrl);
        $this->setDeleteUrl($deleteUrl);
    }

    /**
     * Add a form row
     *
     * @param FormRow $row
     */
    public function addRow(FormRow $row)
    {
        if(!in_array($row, $this->rows)){
            $row->setForm($this);
            array_push($this->rows, $row);
        }

    }

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * @param Model $model
     */
    public function setModel(Model $model): void
    {
        $this->model = $model;
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
            'name' => $this->name,
            'methods' => (array) $u,
            'rows' => (array) $r
        );

        return $json;
    }
}
