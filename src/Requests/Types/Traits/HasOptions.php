<?php
namespace Foundry\Requests\Types\Traits;

use Foundry\Requests\Types\Type;

trait HasOptions {

	/**
	 * @var bool $multiple Used to determine if we allow multiple selections (chechbox vs radio, or select vs select[multiple]
	 */
	protected $multiple;

	/**
	 * @var array $options Available options
	 */
	protected $options;

	/**
	 * @var bool Determines if the options are expanded, such as in a series of checkboxes or radios
	 */
	protected $expanded;

	/**
	 * @var mixed The empty option. Null or false for none. True for default text or a string for the displayed text
	 */
	protected $empty;

	/**
	 * @return mixed
	 */
	public function isExpanded()
	{
		return $this->expanded;
	}

	/**
	 * @param mixed $expanded
	 *
	 * @return Type
	 */
	public function setExpanded($expanded):  Type
	{
		$this->expanded = $expanded;
		return $this;
	}


	/**
	 * @return bool
	 */
	public function isMultiple(): bool
	{
		return $this->multiple;
	}

	/**
	 * @param bool $multiple
	 *
	 * @return Type
	 */
	public function setMultiple(bool $multiple): Type
	{
		$this->multiple = $multiple;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getOptions(): array
	{
		return $this->options;
	}

	/**
	 * @param array $options
	 *
	 * @return Type
	 */
	public function setOptions(array $options): Type
	{
		$this->options = $options;
		return $this;
	}

	/**
	 * Determines if a value is selected
	 *
	 * @param $key
	 *
	 * @return bool
	 */
	public function isOptionChecked($key)
	{
		if (is_array($this->value)) {
			return in_array($key, $this->value);
		} elseif (is_string($this->value)) {
			return $key == $this->value;
		}
		return false;
	}

	public function setEmpty($value) : Type
	{
		$this->empty = $value;
		return $this;
	}

	public function getEmpty($value)
	{
		return $this->empty;
	}

	public function getEmptyLabel($default = null)
	{
		if ($this->empty === true) {
			if ($default !== null) {
				return $default;
			} else {
				return __('Select...');
			}
		} elseif (is_string($this->empty)) {
			return $this->empty;
		}
	}

	public function hasEmptyOption()
	{
		return !!($this->empty);
	}

}