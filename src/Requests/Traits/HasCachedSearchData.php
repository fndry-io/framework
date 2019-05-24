<?php

namespace Foundry\Requests\Traits;


trait HasCachedSearchData {

    /**
     * @param string $key
     * @param string $name
     * @return mixed|null
     */
    static function getCachedFilterField(string $key, string $name)
    {
        $searches = session('searches');
        $cachedInputs = [];

        if($searches){
            $cachedInputs = isset($searches[$name])
                ? $searches[$name]: []
            ;
        }

        return isset($cachedInputs[$key])
            ?$cachedInputs[$key] : null;
    }

    /**
     * @param array $inputs | search inputs
     * @param string $name | name of form request
     * @param array $fields | available search fields
     * @param boolean $reset | is search being reset?
     *
     * @return array
     */
    static function cacheSearches(array $inputs, string $name, array $fields, bool $reset = false)
    {
        $cachedInputs = [];

        $searches = session('searches');

        if($searches){
            $cachedInputs = isset($searches[$name])
                ? $searches[$name]: []
            ;
        }

        if(!$reset){
            foreach ($fields as $field){
                if(!isset($inputs[$field])){
                    if(array_key_exists($field, $inputs)){
                        unset($inputs[$field]);
                    }
                    elseif(isset($cachedInputs[$field])){
                        $inputs[$field] = $cachedInputs[$field];
                    }

                }
            }
        }else{
            $inputs = [];
        }

        $searches[$name] = $inputs;

        session()->put('searches', $searches);

        return $inputs;
    }

}
