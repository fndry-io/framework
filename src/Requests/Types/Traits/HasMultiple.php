<?php
/**
 * Created by PhpStorm.
 * User: greg
 * Date: 14/Jan/2019
 * Time: 2:16 PM
 */

namespace Foundry\Requests\Types\Traits;


trait HasMultiple {

	/**
	 * @var bool $multiple Used to determine if we allow multiple selections (collections, chechbox vs radio, or select vs select[multiple]
	 */
	protected $multiple;

	/**
	 * @return bool
	 */
	public function getMultiple(): int
	{
		return $this->multiple;
	}

	/**
	 * @param int $multiple
	 *
	 * @return $this
	 */
	public function setMultiple(int $multiple)
	{
		$this->multiple = $multiple;
		return $this;
	}

}