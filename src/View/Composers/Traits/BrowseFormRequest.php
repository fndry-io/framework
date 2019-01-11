<?php
namespace Foundry\View\Composers\Traits;

use Foundry\Requests\FormRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

trait BrowseFormRequest {

	/**
	 * Bind data to the view.
	 *
	 * @param string $class The FormQuest class to use
	 * @param Request $request The current request
	 * @param View $view The view to update
	 * @return void
	 */
	public function handle(string $class, Request $request, View &$view)
	{
		/**
		 * @var FormRequest $class
		 */
		$response = $class::handleRequest( $request );

		if ($response->isSuccess()) {
			$form = $class::view();
			$form
				->setRequest( $request )
				->setMethod( 'GET' )
				->setSubmit( __( 'Filter' ) )
				->setValues( $request->only($class::fields() ) )
			;
			if ( !$response->isSuccess() ) {
				$form->setErrors($response->getError());
			}
			$view->with([
				'data' => $response->getData(),
				'form' => $form
			]);
		} else {
			abort($response->getCode(), $response->getMessage());
		}
	}

}