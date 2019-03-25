<?php

namespace Foundry\View\Components\Traits;

use Foundry\Requests\FormRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

trait HasViewFormRequest {

	/**
	 * Bind data to the view.
	 *
	 * @param string $class The FormQuest class to use
	 * @param Request $request The current request
	 * @param View $view The view to update
	 *
	 * @return void
	 */
	public function handleRequest( string $class, Request $request, View &$view, $model = null ) {
		/**
		 * @var FormRequest $class
		 */
		$form = $class::view( $request, $model );
		$this->set( [
			'form' => $form
		] );
	}

}