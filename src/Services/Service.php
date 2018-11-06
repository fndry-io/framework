<?php

namespace Foundry\Services;


/**
 * Class Service
 *
 * @package Foundry\Services
 *
 * @author Medard Ilunga
 */
abstract class Service {

    /**
     * Json response
     * @param array $data
     * @return mixed
     */
    static function jsonResponse($data=[]){
        $json_response['status'] = true;
        $json_response['code'] = 200;
        $json_response['data'] = $data;

        return $json_response;
    }

    /**
     * Json error response
     *
     * @param $error
     * @param $code
     * @return mixed
     */
    static function jsonErrorResponse($error, $code){
        $json_response['status'] = false;
        $json_response['code'] = $code;
        $json_response['data'] = null;
        $json_response['error'] = $error;

        return $json_response;
    }
}
