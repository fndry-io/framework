<?php

namespace Foundry\Requests\Types;

use Foundry\Requests\Types\Traits\HasClass;
use Foundry\Requests\Types\Traits\HasId;

/**
 * Class FormView
 *
 * @package Foundry\Requests\Types
 */
class DocType extends ParentType {


	use HasId,
		HasClass
		;

	/**
	 * DocType constructor.
	 *
	 * @param null $id
	 */
    public function __construct($id = null)
    {
    	$this->setId($id);
    	$this->setType('doc');
    }

}
