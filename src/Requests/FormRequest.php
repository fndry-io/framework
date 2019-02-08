<?php

namespace Foundry\Requests;

use Carbon\Carbon;
use Foundry\Models\InputCollection;
use Foundry\Requests\Types\DocType;
use Foundry\Requests\Types\FormType;
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
abstract class FormRequest {
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

	public function __construct( $inputs ) {
		$this->setInputs( $inputs );
		$this->rules = static::rules();
	}

	/**
	 * Set the inputs
	 *
	 * @param $inputs
	 *
	 * @return $this
	 */
	public function setInputs( $inputs ) {

		$inputs = static::typedValues($inputs);
		$this->inputs = $inputs;
		return $this;
	}

	/**
	 * Get the inputs
	 *
	 * @return array
	 */
	public function getInputs() {
		return $this->inputs;
	}

	/**
	 * @param Request $request
	 *
	 * @param Model|null $model
	 *
	 * @return FormRequest
	 */
	static public function fromRequest( Request $request, $model = null ) {
		$fields = $request->input();
		$form   = new static( static::only( static::fields(), $fields ) );
		$form->setRequest( $request );
		if ( $model ) {
			$form->setModel( $model );
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
	static public function handleRequest( Request $request, $model = null ) {
		$form = static::fromRequest( $request, $model );

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
	static public function handleFormViewRequest( Request $request, $model = null ) {
		$form = static::fromRequest( $request, $model );
		if ( $form->authorize() ) {
			$formView = $form::view( $request, $model );

			return Response::success( $formView->jsonSerialize() );
		} else {
			return Response::error( __( "You are not authorized to view the requested form" ), 403 );
		}
	}

	/**
	 * Set the request
	 *
	 * @param Request|null $request
	 *
	 * @return $this
	 */
	public function setRequest( Request $request = null ) {
		$this->request = $request;

		return $this;
	}

	/**
	 * Get the request
	 *
	 * @return mixed
	 */
	public function getRequest() {
		return $this->request;
	}

	/**
	 * Set the rules
	 *
	 * @param $rules
	 */
	public function setRules( $rules ) {
		$this->rules = $rules;
	}

	/**
	 * Get the set rules
	 *
	 * @return array
	 */
	public function getRules( ) {
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
	static public function rules( Model $model = null ): array {
		return static::inputCollection( $model )->rules( );
	}


	/**
	 * Get available fields based on the permissions of the currently logged in user.
	 *
	 * @return array
	 */
	static function fields(): array {
		return static::inputCollection()->keys()->toArray();
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
	 * @return string
	 */
	static abstract function service();

	/**
	 * @param null $model
	 *
	 * @return InputCollection
	 */
	static function inputCollection( $model = null ): InputCollection {
		return new InputCollection();
	}

	/**
	 * Gets the form type for managing the form
	 *
	 * @param Request|null $request
	 * @param Model|null $model
	 *
	 * @return FormType
	 */
	static abstract function form( Request $request = null, $model = null ): FormType;

	/**
	 * Gets the DocType for sending to a renderer to render
	 *
	 * @param Request|null $request
	 * @param Model|null $model
	 *
	 * @return DocType
	 */
	static abstract function view( Request $request = null, $model = null ): DocType;

	/**
	 * Get the model for a given id
	 *
	 * @param $id
	 *
	 * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null|object
	 */
	static public function model( $id ) {
		return call_user_func( [ static::service(), 'model' ], $id );
	}

	/**
	 * Set the types to cast inputs to
	 *
	 * @see http://php.net/manual/en/function.settype.php
	 * @return array
	 * @todo this should change to casts
	 */
	static public function types() {
		return static::inputCollection()->casts();
	}

	/**
	 * Set the model to use with this form Form Request
	 */
	public function setModel( Model $model ): FormRequest {
		$this->model = $model;
		$this->setRules( static::rules( $model ) );

		return $this;
	}

	/**
	 * Get the associated model
	 *
	 * @return mixed
	 */
	public function getModel() {
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
	public function validate( $rules = null, $authorise = true ) {
		if ( $rules === null ) {
			$rules = $this->getRules();
		}
		if ( ! $authorise || $this->authorize() ) {
			if ( $rules ) {
				$validator = Validator::make( $this->inputs, $rules, $this->messages() );
				if ( $validator->fails() ) {
					return Response::error( $validator->errors()->getMessages(), 422 );
				}
			}

			return Response::success( $this->inputs );
		} else {
			return Response::error( __( "You are not authorized to view the requested data" ), 403 );
		}
	}

	/**
	 * Extract only the wanted keys from the inputs
	 *
	 * @param $keys
	 *
	 * @return array
	 */
	static function only( $keys, $input ) {
		$results = [];

		$placeholder = new \stdClass;

		foreach (is_array($keys) ? $keys : func_get_args() as $key) {
			$value = static::data_get($input, $key, $placeholder);

			if ($value !== $placeholder) {
				Arr::set($results, $key, $value);
			}
		}

		return static::array_correct($results);
	}

	static function array_correct($array)
	{
		$_array = [];
		foreach ($array as $key => $value) {
			if ($key === '*') {
				//the keys now are the keys for each value inside the array
				$_value = [];
				foreach ($value as $k => $values) {
					if (is_array($values)) {
						foreach ($values as $index => $v) {
							$_value[$index][$k] = $v;
						}
					} else  {
						$_value[$k] = $values;
					}
				}
				$_array = $_value;
			} elseif (is_array($value) && Arr::isAssoc($value)) {
				$_array[$key] = static::array_correct($value);
			} else {
				$_array[$key] = $value;
			}
		}
		return $_array;
	}

	/**
	 * Get an item from an array or object using "dot" notation.
	 *
	 * @param  mixed   $target
	 * @param  string|array|int  $key
	 * @param  mixed   $default
	 * @return mixed
	 */
	static function data_get($target, $key, $default = null)
	{
		if (is_null($key)) {
			return $target;
		}

		$key = is_array($key) ? $key : explode('.', $key);

		while (! is_null($segment = array_shift($key))) {
			if ($segment === '*') {
				if ($target instanceof Collection) {
					$target = $target->all();
				} elseif (! is_array($target)) {
					return value($default);
				}

				$result = [];

				foreach ($target as $item) {
					$result[] = data_get($item, $key);
				}

				return $result;
			}

			if (Arr::accessible($target) && Arr::exists($target, $segment)) {
				$target = $target[$segment];
			} elseif (is_object($target) && isset($target->{$segment})) {
				$target = $target->{$segment};
			} else {
				return value($default);
			}
		}

		return $target;
	}

	/**
	 * Converts the values to their typed equivalents
	 *
	 * @param $values
	 *
	 * @return mixed
	 */
	static public function typedValues( $values ) {
		$casts = static::types();
		foreach ($casts as $key => $cast) {
			$value = array_get($values, $key);
			if ($value !== "" && $value !== null) {
				if ($cast === 'datetime') {
					$value = Carbon::parse($value, 'UTC');
				}elseif ($cast === 'array_int') {
					$value = array_map(function($item){
						return (int) $item;
					}, (array) $value);
				} else {
					settype( $value, $cast );
				}
				array_set($values, $key, $value);
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
	public function except( $keys ) {
		return array_except( $this->inputs, $keys );
	}

	/**
	 * Handle the form request
	 *
	 * @return Response
	 */
	abstract public function handle(): Response;

	/**
	 * Handle the form using the given service
	 *
	 * @param string $service The Service class name to the use
	 * @param string $method The static method to call against the service class
	 *
	 * @return mixed|Response|View
	 */
	protected function response( $response ) {
		$this->setResponse( $response );
		if ( $this->response->isSuccess() ) {
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
	public function setResponse( $response ) {
		$this->response = $response;

		return $this;
	}

	/**
	 * Get the foundry response object
	 *
	 * @return Response
	 */
	public function getResponse() {
		return $this->response;
	}

	/**
	 * Set the view for rendering this form
	 *
	 * @param $view
	 *
	 * @return FormRequest
	 */
	public function setView( $view ): FormRequest {
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
	public function onSuccess( \Closure $closure ): FormRequest {
		$this->onSuccess = $closure;

		return $this;
	}

	/**
	 * @return mixed|Response|View
	 */
	protected function handleOnSuccess() {
		if ( isset( $this->onSuccess ) && is_callable( $this->onSuccess ) ) {
			return call_user_func( $this->onSuccess, $this );
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
	public function onError( \Closure $closure ): FormRequest {
		$this->onError = $closure;

		return $this;
	}

	/**
	 * Handle On Error
	 *
	 * @return mixed|Response|View
	 */
	protected function handleOnError() {
		if ( isset( $this->onError ) && is_callable( $this->onError ) ) {
			$return = call_user_func( $this->onError, $this );
			if ( $return instanceof RedirectResponse ) {
				$error = $this->response->getError();
				if ( is_string( $error ) ) {
					$return->with( 'status', $error );
				} elseif ( is_array( $error ) ) {
					$return->withErrors( $error, 'form' );
				}
			}

			return $return;
		} elseif ( ! empty( $this->view ) ) {
			$form = $this->getFormView();
			$form
				->setAction( $this->action )
				->setMethod( $this->method );
			$error = $this->response->getError();
			if ( $this->response->getCode() === 422 ) {
				$form->setErrors( new MessageBag( $error ) );
			} elseif ( is_string( $error ) ) {
				app( 'session' )->flash( 'status', $error );
			}

			return view( $this->view, [
				'form' => $form
			] );
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
	public function setAction( $action ) {
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
	public function setMethod( $method ) {
		$this->method = $method;

		return $this;
	}

	/**
	 * Get an input value or return the default
	 *
	 * @param $key
	 * @param null $default
	 *
	 * @return mixed|null
	 */
	public function input( $key, $default = null ) {
		return data_get($this->inputs, $key, $default);
	}


}
