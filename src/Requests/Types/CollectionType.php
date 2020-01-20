<?php

namespace Foundry\Requests\Types;

use Foundry\Requests\Types\Traits\HasButtons;
use Foundry\Requests\Types\Traits\HasMinMax;
use Foundry\Requests\Types\Traits\HasMultiple;
use Foundry\Requests\Types\Traits\HasName;

class CollectionType extends ParentType {

    /**
     * //todo refactor to its own class
     * @var null
     */
    protected $manageList = null;

    use HasMinMax,
        HasMultiple,
        HasButtons,
        HasName;

    public function __construct( $name ) {
        $this->setName( $name );
        $this->setType( 'collection' );
    }

    /**
     * @param array $config
     * @return CollectionType
     */
    public function setManageList(array $config)
    {
        $this->manageList = $config;

        return $this;
    }

    public function getManageList()
    {
        return $this->manageList;
    }

}
