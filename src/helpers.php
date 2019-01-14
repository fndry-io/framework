<?php

if (! function_exists('setting')) {
    /**
     * Get / set the specified setting value.
     *
     * If an array is passed as the key, we will assume you want to set an array of settings key => values.
     *
     * @param  array|string  $key
     * @param  mixed  $default
     * @return mixed|\Foundry\Config\SettingRepository
     */
    function setting($key = null, $default = null)
    {
        if (is_null($key)) {
            return app('settings');
        }

        if (is_array($key)) {
            return app('settings')->set($key);
        }

        return app('settings')->get($key, $default);
    }

}

if (! function_exists('request_merge')) {

	/**
	 * Merge additional fields into a request object
	 *
	 * @param \Illuminate\Http\Request $request | the actual request object
	 * @param array $values | associative array of key = value to be merged into the request
	 * @param null|string $key The key containing values in the request object
	 *
	 * @return \Illuminate\Http\Request
	 */
    function request_merge(\Illuminate\Http\Request $request, $values, $key = null)
    {
        if($key){
            $new = $request->only($key)[$key];
            foreach ($values as $k => $v){
                $new[$k] = $v;
                $request->merge([$key => $new]);
            }
        }else{
            $request->merge($values);
		}
        return $request;
    }
}


if (! function_exists('routeUri')) {
	/**
	 * Get the URI to a named route.
	 *
	 * @param  array|string  $name
	 * @return string
	 */
	function routeUri($name)
	{
		if (! is_null($route = app('router')->getRoutes()->getByName($name))) {
			return url($route->uri());
		}
		throw new InvalidArgumentException("Route [{$name}] not defined.");
	}
}


if (! function_exists('strip_non_utf8')) {
	/**
	 * Remove non utf-8 characters from a string
	 *
	 * @param $string
	 *
	 * @return string
	 */
	function strip_non_utf8( $string ) {
		return iconv( "UTF-8", "UTF-8//IGNORE", $string );
	}
}