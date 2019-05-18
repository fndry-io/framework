<?php

namespace Foundry\Core\Inputs\Types;

use Foundry\Core\Inputs\Types\Contracts\Inputable;
use Foundry\Core\Inputs\Types\Traits\HasButtons;
use Foundry\Core\Inputs\Types\Traits\HasClass;
use Foundry\Core\Inputs\Types\Traits\HasEntity;
use Foundry\Core\Inputs\Types\Traits\HasErrors;
use Foundry\Core\Inputs\Types\Traits\HasHelp;
use Foundry\Core\Inputs\Types\Traits\HasId;
use Foundry\Core\Inputs\Types\Traits\HasLabel;
use Foundry\Core\Inputs\Types\Traits\HasMask;
use Foundry\Core\Inputs\Types\Traits\HasModel;
use Foundry\Core\Inputs\Types\Traits\HasName;
use Foundry\Core\Inputs\Types\Traits\HasPlaceholder;
use Foundry\Core\Inputs\Types\Traits\HasPosition;
use Foundry\Core\Inputs\Types\Traits\HasReadonly;
use Foundry\Core\Inputs\Types\Traits\HasRequired;
use Foundry\Core\Inputs\Types\Traits\HasRules;
use Foundry\Core\Inputs\Types\Traits\HasValue;
use Foundry\Core\Inputs\Types\Traits\IsSortable;
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
		HasEntity,
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
		if ( ! $field['value'] && $this->hasEntity() ) {
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
