<?php

namespace Foundry\Requests;

use Foundry\Requests\Types\FormView;
use Foundry\Services\Service;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

/**
 * Class FormRequest
 *
 * @package Foundry\Requests
 */
abstract class FormRequest
{
    /**
     * @var array form inputs
     */
    protected $inputs = [];

    /**
     * @var Response The response received after calling the hanlde method
     */
    protected $response;

    /**
     * @var \Closure The on success handler
     */
    protected $onSuccess;

    /**
     * @var \Closure The on error handler
     */
    protected $onError;

    /**
     * @var string The view for rendering the form
     */
    protected $view;

    /**
     * @var string The action url to submit to
     */
    protected $action;

    /**
     * @var string POST, GET, PUT, DELETE
     */
    protected $method;

    /**
     * @var Model The associated model instance
     */
    protected $model;

    /**
     * @var array The loaded rules
     */
    protected $rules;

	/**
	 * @var string The associated Service Class name
	 */
    protected $service;

	/**
	 * @var Request The request object
	 */
    protected $request;

    public function __construct($inputs)
    {
        $this->setInputs($inputs);
        $this->rules = static::rules();
    }

    /**
     * Set the inputs
     *
     * @param $inputs
     *
     * @return $this
     */
    public function setInputs($inputs)
    {
        $this->inputs = $inputs;
        return $this;
    }

    /**
     * Get the inputs
     *
     * @return array
     */
    public function getInputs()
    {
        return $this->inputs;
    }

    /**
     * @param Request $request
     *
     * @param Model|null $model
     * @return FormRequest
     */
    static public function fromRequest(Request $request, $model = null)
    {
        $fields = $request->only(static::getFormView()->getName());

        $fields = sizeof($fields) === 0? $request->input() : $fields[static::getFormView()->getName()];

        $form = new static(static::only(static::fields(), $fields));
        $form->setRequest($request);
	    if ($model) {
		    $form->setModel($model);
	    }
        return $form;
    }

    /**
     * Handle the request
     *
     * @param Request $request
     * @param $model
     *
     * @return Response
     */
    static public function handleRequest(Request $request, $model = null)
    {
        $form = static::fromRequest($request, $model);
        return $form->handle();
    }

	/**
	 * Handle the form view request
	 *
	 * @param Request $request
	 * @param $model
	 *
	 * @return Response
	 */
	static public function handleFormViewRequest(Request $request, $model = null)
	{
		$form = static::fromRequest($request, $model);
		if($form->authorize()){
			$formView = $form::view( $model );
			$formView->setRequest($request);
			return Response::success( $formView->jsonSerialize() );
		}else{
			return Response::error(__("You are not authorized to view the requested form"), 403);
		}
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
        return $this;
    }

    /**
     * Get the request
     *
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Set the rules
     *
     * @param $rules
     */
    public function setRules($rules)
    {
        $this->rules = $rules;
    }

    /**
     * Get the set rules
     *
     * @return array
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * These are the initial default rules
     *
     * Call getRules and setRules to modify when and if needed
     *
     * @param Model $model The model if rules need modifying
     *
     * @return array
     */
    static function rules(Model $model = null): array {
    	return [];
    }

    /**
     * Get available fields based on the permissions of the currently logged in user.
     *
     * @return array
     */
    static function fields(): array {
	    return [];
    }

    /**
     * Get custom error messages for rules
     *
     * @return array
     */
    public function messages() {
        return [];
    }

	/**
	 * Returns a unique name for the Form Request object
	 *
	 * This is used in handling the request with the FormRequestHandler
	 *
	 * @return string
	 */
	abstract static function name();

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public abstract function authorize();

	/**
     * Returns the service for this form
     *
     * @return Service
     */
    static abstract function service();

    /**
     * Gets the form view object for rendering the form
     *
     * @param Model|null $model
     *
     * @return FormView
     */
    static abstract function getFormView($model = null): FormView;

	static function view($model = null)
	{
		$form = static::getFormView($model);

		//get the model and set it to the form view
		if ( $model ) {
			$form->setModel( $model );
		} else {
			$model = null;
		}

		$form->setRules( static::rules( $model ) );

		return $form;
	}

	/**
     * Get the model for a given id
     *
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null|object
     */
    static public function model($id)
    {
        return call_user_func([static::service(), 'model'], $id);
    }

    /**
     * Set the types to cast inputs to
     *
     * @see http://php.net/manual/en/function.settype.php
     * @return array
     */
    static public function types()
    {
        return [];
    }

    /**
     * Set the model to use with this form Form Request
     */
    public function setModel(Model $model): FormRequest
    {
        $this->model = $model;
        $this->setRules(static::rules($model));
        return $this;
    }

    /**
     * Get the associated model
     *
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Get values provided by user
     * Validate the values first before returning
     *
     * @param array|null $rules The rules to apply if custom
     * @param boolean $authorise Should we authorise. Defaults to true.
     *
     * @return Response
     */
	public function validate($rules = null, $authorise = true)
	{
		if ($rules === null) {
			$rules = $this->getRules();
		}
		if(!$authorise || $this->authorize()){
			if ($rules) {
				$validator = Validator::make($this->inputs, $rules, $this->messages());
				if ($validator->fails()) {
					return Response::error($validator->errors()->getMessages(), 422);
				}
			}
			return Response::success($this->inputs);
        }else{
            return Response::error(__("You are not authorized to view the requested data"), 403);
        }
    }

    /**
     * Extract only the wanted keys from the inputs
     *
     * @param $keys
     *
     * @return array
     */
    static function only($keys, $inputs)
    {
        $results = [];

        $placeholder = new \stdClass();

        foreach (is_array($keys) ? $keys : [$keys] as $key) {
            $value = data_get($inputs, $key, $placeholder);

            if ($value !== $placeholder) {
                Arr::set($results, $key, $value);
            }
        }

        return $results;
    }

    /**
     * Converst the values to their typed equivilents
     *
     * @param $values
     *
     * @return mixed
     */
    static public function typedValues($values)
    {
        $cast = static::types();
        foreach ($values as $key => $value) {
            if (isset($cast[$key])) {
                if ($value === "" || $value === null) {
                    $values[$key] = null;
                } else {
                    settype($values[$key], $cast[$key]);
                }
            }
        }
        return $values;
    }

    /**
     * Extract only the wanted keys from the input
     *
     * @param $keys
     *
     * @return array
     */
    public function except($keys)
    {
        return array_except($this->inputs, $keys);
    }

    /**
     * Handle the form request
     *
     * @return Response
     */
    abstract public function handle() : Response;

    /**
     * Handle the form using the given service
     *
     * @param string $service The Service class name to the use
     * @param string $method The static method to call against the service class
     *
     * @return mixed|Response|View
     */
    protected function response($response)
    {
        $this->setResponse($response);
        if ($this->response->isSuccess()) {
            return $this->handleOnSuccess();
        } else {
            return $this->handleOnError();
        }
    }

    /**
     * Set the foundry response object
     *
     * @param Response $response
     *
     * @return $this
     */
    public function setResponse($response)
    {
        $this->response = $response;
        return $this;
    }

    /**
     * Get the foundry response object
     *
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Set the view for rendering this form
     *
     * @param $view
     *
     * @return FormRequest
     */
    public function setView($view) : FormRequest
    {
        $this->view = $view;
        return $this;
    }

    /**
     * Set the on Success handler
     *
     * @param \Closure $closure
     *
     * @return FormRequest
     */
    public function onSuccess(\Closure $closure) : FormRequest
    {
        $this->onSuccess = $closure;
        return $this;
    }

    /**
     * @return mixed|Response|View
     */
    protected function handleOnSuccess()
    {
        if (isset($this->onSuccess) && is_callable($this->onSuccess)) {
            return call_user_func($this->onSuccess, $this);
        } else {
            return $this->response;
        }
    }

    /**
     * Set the on Error handling
     *
     * @param \Closure $closure
     *
     * @return FormRequest
     */
    public function onError(\Closure $closure) : FormRequest
    {
        $this->onError = $closure;
        return $this;
    }

    /**
     * Handle On Error
     *
     * @return mixed|Response|View
     */
    protected function handleOnError()
    {
        if (isset($this->onError) && is_callable($this->onError)) {
            $return = call_user_func($this->onError, $this);
            if ($return instanceof RedirectResponse) {
                $error = $this->response->getError();
                if (is_string($error)) {
                    $return->with('status', $error);
                } elseif (is_array($error)) {
                    $return->withErrors($error, 'form');
                }
            }
            return $return;
        } elseif (!empty($this->view)) {
            $form = $this->getFormView();
            $form
                ->setAction($this->action)
                ->setMethod($this->method)
            ;
            $error = $this->response->getError();
            if ($this->response->getCode() === 422) {
                $form->setErrors(new MessageBag($error));
            } elseif(is_string($error)) {
                app('session')->flash('status', $error);
            }
            return view($this->view, [
                'form' => $form
            ]);
        } else {
            return $this->response;
        }
    }


    /**
     * Set the form action
     *
     * @param $action
     *
     * @return $this
     */
    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }

    /**
     * Set the method of the form
     *
     * @param $method
     *
     * @return $this
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    public function input($key)
    {
    	return isset($this->inputs[$key]) ? $this->inputs[$key] : null;
    }

}
