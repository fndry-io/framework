<?php

namespace Foundry\Requests;


use Foundry\Exceptions\APIException;
use Illuminate\Support\Facades\Validator;

abstract class Form
{

    protected $inputs = [];

    public function __construct($inputs)
    {
        $this->inputs = $inputs;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public abstract function rules();

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public abstract function authorize();

    /**
     * Get available fields based on the permissions of the currently logged in user.
     *
     * @return array
     */
    static abstract function fields();

    /**
     * Get custom error messages for rules
     *
     * @return array
     */
    public abstract function messages();

    public abstract function getFormView();

    /**
     * Get values provided by user
     * Validate the values first before returning
     *
     * @return array
     */
    public function inputs()
    {
        if($this->authorize()){
            $validator = Validator::make($this->inputs, $this->rules(), $this->messages());

            if ($validator->fails()) {
                return Response::errorResponse($validator->errors()->getMessages(), 422);
            }else{
                return Response::response($this->inputs);
            }
        }else{
            return Response::errorResponse(APIException::NOT_AUTHORIZED, 403);
        }
    }

}
