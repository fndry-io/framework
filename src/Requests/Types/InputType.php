<?php

namespace Foundry\Requests\Types;

use Foundry\Requests\Types\Contracts\Inputable;
use Foundry\Requests\Types\Traits\HasButtons;
use Foundry\Requests\Types\Traits\HasClass;
use Foundry\Requests\Types\Traits\HasErrors;
use Foundry\Requests\Types\Traits\HasHelp;
use Foundry\Requests\Types\Traits\HasId;
use Foundry\Requests\Types\Traits\HasLabel;
use Foundry\Requests\Types\Traits\HasMask;
use Foundry\Requests\Types\Traits\HasModel;
use Foundry\Requests\Types\Traits\HasName;
use Foundry\Requests\Types\Traits\HasPlaceholder;
use Foundry\Requests\Types\Traits\HasPosition;
use Foundry\Requests\Types\Traits\HasReadonly;
use Foundry\Requests\Types\Traits\HasRequired;
use Foundry\Requests\Types\Traits\HasRules;
use Foundry\Requests\Types\Traits\HasValue;
use Foundry\Requests\Types\Traits\IsSortable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Type
 *
 * @package Foundry\Requests\Types
 */
abstract class InputType extends BaseType implements Inputable {

	use HasButtons,
		HasId,
		HasLabel,
		HasValue,
		HasRules,
		HasClass,
		HasName,
		HasPosition,
		HasRequired,
		HasPlaceholder,
		HasHelp,
		HasReadonly,
		HasErrors,
		IsSortable,
		HasModel,
		HasMask
	;


	public function __construct(
		string $name,
		string $label = null,
		bool $required = true,
		$value = null,
		string $position = 'full',
		string $rules = null,
		string $id = null,
		string $placeholder = null,
		string $type = 'text'
	) {
		$this->setName( $name );
		$this->setType( $type );
		$this->setRequired( $required );

		$this->setLabel( $label ? $label : $name );
		$this->setValue( $value );
		$this->setPosition( $position );
		$this->setRules( $rules );

		$this->setId( $id );
		$this->setPlaceholder( $placeholder ? $placeholder : $label ? $label : $name );
	}

	/**
	 * Json serialise field
	 *
	 * @return array
	 */
	public function jsonSerialize(): array
	{

		$field = parent::jsonSerialize();

		//set the value
		if ( ! $field['value'] && $this->hasModel() ) {
			$field['value'] = $this->getModelValue( $this->getName() );
		}

		//set the rules
		if ( $field['rules'] ) {
			$_rules = [];
			$rules  = $this->getRules();
			if ( $rules ) {
				foreach ( $rules as $rule ) {
					if ( is_callable( $rule ) ) {
						continue;
					}
					if ( is_object( $rule ) ) {
						$_rules[] = (string) $rule;
					} elseif ( is_string( $rule ) ) {
						$_rules[] = $rule;
					}
				}
				$_rules = implode( '|', $_rules );
			}
			$field['rules'] = $_rules;
		}

		//set the fillable etc values
		foreach (
			[
				'fillable' => 'isFillable',
				'visible'  => 'isVisible',
				'hidden'   => 'isHidden'
			] as $key => $method
		) {
			$field[ $key ] = call_user_func( [ $this, $method ] );
		}

		return $field;
	}



	public function display($value = null) {
		$value = $this->getValue();
		return $value;
	}
}
