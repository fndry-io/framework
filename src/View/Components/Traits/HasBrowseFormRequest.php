<?php

namespace Foundry\View\Components\Traits;

use Foundry\Requests\Contracts\ColumnInterface;
use Foundry\Requests\FormRequest;
use Foundry\Requests\Types\DocType;
use Foundry\Requests\Types\FormType;
use Foundry\Requests\Types\ResetButtonType;
use Foundry\Requests\Types\SubmitButtonType;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

trait HasBrowseFormRequest {

	/**
	 * Bind data to the view.
	 *
	 * @param string $class The FormQuest class to use
	 * @param Request $request The current request
	 *
	 * @return void
	 */
	public function handleRequest( string $class, Request $request ) {
		/**
		 * @var FormRequest $class
		 */
		$response = $class::handleRequest( $request );

		if ( $response->isSuccess() ) {
			$this->viewRequest( $class, $request, $response );
		} else {
			abort( $response->getCode(), $response->getMessage() );
		}
	}

	/**
	 * @param string $class
	 * @param Request $request
	 * @param $response
	 */
	protected function viewRequest( string $class, Request $request, $response = null ): void {
		/**
		 * @var FormType $form
		 */
		$form = $class::form( $request, null );
		$doctype = null;
		if ($inputs = $form->getInputs()) {
			$form
				->setMethod( 'GET' )
				->setButtons(
					( new SubmitButtonType( __( 'Filter' ), $form->getAction() ) )
					//,( new ResetButtonType( __( 'Reset' ), $form->getAction() ) )
				);

			if ( $response && ! $response->isSuccess() ) {
				$form->setErrors( $response->getError() );
			}
			$form->addChildren(...array_values($inputs));
			$doctype = DocType::withChildren( $form );
		}

		$this->set([
			'data' => ($response) ? $response->getData() : null,
			'form' => $doctype
		] );
		if ( method_exists( $class, 'columns' ) ) {
			$this->set( 'columns', $class::columns() );
		}
	}

}