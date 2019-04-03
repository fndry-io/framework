<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Settings Default values
    |--------------------------------------------------------------------------
    |
    */

    'settings' => [
        'class' => \Foundry\Models\Setting::class,
        'table' => 'settings'
    ],

    'pick-lists' => [
	    'model' => \Foundry\Models\PickList::class,
	    'table' => 'pick_lists'
    ],

    'pick-list-items' => [
	    'model' => \Foundry\Models\PickListItem::class,
	    'table' => 'pick_list_items'
    ],

    'state' => [
	    'model' => \Foundry\Models\State::class,
	    'table' => 'states'
    ],


];
