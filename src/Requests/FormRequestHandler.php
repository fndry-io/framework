<?php

namespace Foundry\Core\Requests;

use Foundry\Core\Exceptions\FormRequestException;
use Illuminate\Database\Eloquent\Model;

/**
 * FormRequestHandler
 *
 * This class helps us register and handle form requests
 *
 * Form requests are the basics for doing requests to the Foundry Framework and help us to wrap the system and return
 * standard Foundry Responses for each request
 *
 * @package Foundry\Requests
 */
class FormRequestHandler implements \Foundry\Contracts\FormRequestHandler {

	protected $forms;

	/**
	 * Register a form request class
	 *
	 * @param string $class The class name
	 *
	 * @return void
	 * @throws FormRequestException
	 */
	public function register( $class, $key = null ) {
		if ( is_array( $class ) ) {
			foreach ( $class as $_class ) {
				$this->registerForm( $_class );
			}
		} else {
			$this->registerForm( $class, $key );
		}
	}

	protected function registerForm( $class, $key = null ) {
		if ( $key == null ) {
			$key = forward_static_call( [ $class, 'name' ] );
		}
		if ( isset( $this->forms[ $key ] ) ) {
			throw new FormRequestException( sprintf( "Form key %s already used", $key ) );
		}
		$this->forms[ $key ] = $class;
	}

	/**
	 * Handle the requested form with the request
	 *
	 * @param $key
	 * @param $request
	 * @param Model|string|int $id
	 *
	 * @return Response
	 * @throws FormRequestException
	 */
	public function handle( $key, $request, $id = null ): Response {
		$form = $this->getForm( $key );
		if ( is_object($id) ) {
			$model = $id;
		} elseif ( $id ) {
			$model = $form::model( $id );
		} else {
			$model = null;
		}

		return $form::handleRequest( $request, $model );
	}

	/**
	 * Generate the form view object for a requested form and the request
	 *
	 * @param $key
	 * @param $request
	 * @param $id
	 *
	 * @return Response
	 * @throws FormRequestException
	 */
	public function view( $key, $request, $id = null ): Response {
		$form = $this->getForm( $key );
		if ( $id ) {
			$model = $form::model( $id );
		} else {
			$model = null;
		}

		return $form::handleFormViewRequest( $request, $model );
	}

	/**
	 * Get the form request class
	 *
	 * @param $key
	 *
	 * @return FormRequest
	 * @throws FormRequestException
	 */
	protected function getForm( $key ): string {
		if ( ! isset( $this->forms[ $key ] ) ) {
			throw new FormRequestException( sprintf( "Form %s not registered", $key ) );
		}

		return $this->forms[ $key ];
	}

	/**
	 * List all the registered forms
	 *
	 * @return array
	 */
	public function getList()
	{
		return array_keys($this->forms);
	}

}