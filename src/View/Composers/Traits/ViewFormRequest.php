<?php
namespace Foundry\View\Composers\Traits;

use Foundry\Requests\FormRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

trait ViewFormRequest {

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
		$form = $class::view();
		$form
			->setRequest( $request )
			->setValues( $request->only($class::fields() ) )
		;
		$view->with([
			'form' => $form
		]);
	}

}