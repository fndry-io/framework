<?php

namespace Foundry\Core\Entities\Traits;

/**
 * Trait Fillable
 *
 * @package Foundry\Core\Traits
 */
trait Visible {

	public function isVisible($name)
	{
		if (isset($this->visible) && !in_array($name, $this->visible)) {
			return false;
		}
		return true;
	}

	public function makeVisible($name)
	{
		if (!isset($this->visible)) {
			$this->visible = [];
		}
		if (!in_array($name, $this->visible)) {
			$this->visible[] = $name;
		}
	}

	public function getVisible()
	{
		if (isset($this->visible)) {
			return $this->visible;
		} else {
			return [];
		}
	}

	public function isHidden($name)
	{
		if (isset($this->hidden) && in_array($name, $this->hidden)) {
			return true;
		}
		return false;
	}

	public function makeHidden($name)
	{
		if (!isset($this->hidden)) {
			$this->hidden = [];
		}
		if (!in_array($name, $this->hidden)) {
			$this->hidden[] = $name;
		}
	}

	public function getHidden()
	{
		if (isset($this->hidden)) {
			return $this->hidden;
		} else {
			return [];
		}
	}

}