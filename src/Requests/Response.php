<?php
namespace Foundry\Requests;

/**
 * Foundry Simple Response Object
 *
 * This object will encapsulate and standardise the responses from a service
 *
 * @package Foundry\Requests
 */
class Response
{

	protected $status;

	protected $data = [];

	protected $code;

	protected $error;

	/**
	 * Response Constructor
	 *
	 * @param mixed $data
	 * @param bool $status
	 * @param int $code
	 * @param null $error
	 */
	public function __construct($data = [], $status = true, $code = 200, $error = null)
	{
		$this->data = $data;
		$this->status = $status;
		$this->code = $code;
		$this->error = $error;
	}

	/**
	 * Is the response a success
	 *
	 * @return bool
	 */
	public function isSuccess()
	{
		return $this->status;
	}

	/**
	 * Response
	 * @param array $data
	 * @return Response
	 */
	static function success($data = []){
		return new Response($data);
	}

	/**
	 * Error response
	 *
	 * @param $error
	 * @param $code
	 * @return Response
	 */
	static function error($error, $code){
		return new Response([], false, $code, $error);
	}

	/**
	 * Convert the response to an array
	 *
	 * @return array
	 */
    public function jsonSerialize()
    {
    	$array = [
		    'status' => $this->status,
		    'code' => $this->code,
		    'data' => $this->data
	    ];
    	if ($this->error) {
    		$array['error'] = $this->error;
	    }
    	return $array;
    }

    public function getStatus()
    {
    	return $this->status;
    }

    public function getError()
    {
    	return $this->error;
    }

	public function getCode()
	{
		return $this->code;
	}

	public function getData()
	{
		return $this->data;
	}
}
