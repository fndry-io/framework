<?php

namespace Foundry\View\Composers\Traits;

use Foundry\Requests\Contracts\ColumnInterface;
use Foundry\Requests\FormRequest;
use Foundry\Requests\Types\DocType;
use Foundry\Requests\Types\SubmitButtonType;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

trait BrowseFormRequest {

	protected $request;

	/**
	 * BrowseFormRequest constructor.
	 *
	 * @param Request $request
	 */
	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	/**
	 * Bind data to the view.
	 *
	 * @param string $class The FormQuest class to use
	 * @param Request $request The current request
	 * @param View $view The view to update
	 *
	 * @return void
	 */
	public function handle( string $class, Request $request, View &$view ) {
		/**
		 * @var FormRequest $class
		 */
		$response = $class::handleRequest( $request );

		if ( $response->isSuccess() ) {
			$this->view( $class, $request, $view, $response );
		} else {
			abort( $response->getCode(), $response->getMessage() );
		}
	}

	/**
	 * @param string $class
	 * @param Request $request
	 * @param View $view
	 * @param $response
	 */
	protected function view( string $class, Request $request, View &$view, $response = null ): void {
		$form = $class::form( $request, null );
		$form
			->setMethod( 'GET' )
			->setButtons(
				( new SubmitButtonType( __( 'Filter' ), $form->getName() ) )
			);

		if ( $response && ! $response->isSuccess() ) {
			$form->setErrors( $response->getError() );
		}

		$view->with( [
			'data' => ($response) ? $response->getData() : null,
			'form' => DocType::withChildren( $form )
		] );
		if ( method_exists( $class, 'columns' ) ) {
			$view->with( 'columns', $class::columns() );
		}
	}

}