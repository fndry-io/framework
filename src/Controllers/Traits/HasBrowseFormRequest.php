<?php

namespace Foundry\Controllers\Traits;

use Foundry\Models\InputCollection;
use Foundry\Requests\FormRequest;
use Foundry\Requests\Types\DocType;
use Foundry\Requests\Types\FormType;
use Foundry\Requests\Types\SubmitButtonType;
use Illuminate\Http\Request;
use Plugins\Foundry\System\Policies\HasFieldPermission;

trait HasBrowseFormRequest {

    /**
     * Bind data to the view.
     *
     * @param string $class The FormQuest class to use
     * @param Request $request The current request
     *
     * @return array
     */
    public function handleBrowseRequest( string $class, Request $request ) : array
    {
        /**
         * @var FormRequest $class
         */
        $response = $class::handleRequest( $request );

        if ( $response->isSuccess() ) {
            return $this->handleBrowseResponse( $class, $request, $response );
        } else {
            abort( $response->getCode(), $response->getMessage() );
        }
    }

    /**
     * @param string $class
     * @param Request $request
     * @param $response
     *
     * @return array
     */
    protected function handleBrowseResponse( string $class, Request $request, $response = null ): array {
        /**
         * @var FormType $form
         */
        $form = $class::form( $request, null );
        $doctype = null;

        $data = [];

        $form
            ->setMethod( 'GET' )
            ->setButtons(
                ( new SubmitButtonType( __( 'Filter' ), $form->getAction() ) )
            //,( new ResetButtonType( __( 'Reset' ), $form->getAction() ) )
            );

        if ( $response && ! $response->isSuccess() ) {
            $form->setErrors( $response->getError() );
        }

        if ($inputs = $form->getInputs()) {
            $form->addChildren(...array_values($inputs));
        }

        $doctype = DocType::withChildren( $form );

        $data['form'] = $doctype;
        $data['data'] = ($response) ? $response->getData() : null;

        if ( method_exists( $class, 'columns' ) ) {

            /**
             * @var $collections InputCollection
             */
            $collections = $class::columns();
            $allowed = $collections->keys()->toArray();

            $serviceClass = $class::service();

            if($serviceClass && class_exists($serviceClass)){
                $modelClass = (new $serviceClass())->modelClass();

                if($modelClass && class_exists($modelClass)){

                    $model = new $modelClass();

                    if(key_exists(HasFieldPermission::class, class_uses($model))){

                        $diff = array_diff($allowed, $model->getHidden());

                        $allowed = array();

                        foreach ($diff as $key){

                            $relations = explode('.', $key);
                            $add = true;

                            if(sizeof($relations) > 1 &&
                                isset($model->permissionRelations()[$relations[0]])){

                                $hide = $model->getHidden();

                                for ($i = 0, $j = 1; $j < sizeof($relations); $i++, $j++){

                                    if($add){
                                        $hidden = in_array($relations[$i], $hide);

                                        $c = $model->permissionRelations()[$relations[$i]];

                                        if(isset($c['class'])){

                                            $relatedClass = $c['class'];

                                            $relatedModel = new $relatedClass();

                                            if(!$hidden && key_exists(HasFieldPermission::class, class_uses($relatedModel))){

                                                if(in_array($relations[$j], $relatedModel->getHidden())){
                                                    $add = false;
                                                }

                                            }else{
                                                $add = !$hidden;
                                            }
                                        }

                                    }

                                }

                            }

                            if($add){
                                array_push($allowed, $key);
                            }

                        }
                    }
                }
            }

            $data['columns'] = $collections->only($allowed);
        }

        return $data;
    }

}
