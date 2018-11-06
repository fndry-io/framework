<?php

namespace Foundry\Requests;


class Response
{
    /**
     * Response
     * @param array $data
     * @return mixed
     */
    static function response($data=[]){
        $json_response['status'] = true;
        $json_response['code'] = 200;
        $json_response['data'] = $data;

        return $json_response;
    }

    /**
     * Error response
     *
     * @param $error
     * @param $code
     * @return mixed
     */
    static function errorResponse($error, $code){
        $json_response['status'] = false;
        $json_response['code'] = $code;
        $json_response['data'] = null;
        $json_response['error'] = $error;

        return $json_response;
    }
}
