<?php

namespace Foundry\Requests\Types;

use Foundry\Models\PickListItem;


class PickListInputType extends ChoiceInputType {

	/**
	 * The input options
	 *
	 * @param string $identifier The identifier to get the list items
	 *
	 * @return array
	 */
	static function list( $identifier ): array {
		//todo change this to use a config variable instead for the model name
		return PickListItem::query()
		                   ->select( [ 'pick_list_items.*' ] )
		                   ->join( 'pick_lists', 'pick_list_items.pick_list_id', '=', 'pick_lists.id' )
		                   ->where( 'pick_list_items.status', 1 )
		                   ->where( 'pick_lists.identifier', $identifier )
		                   ->orderBy( 'pick_list_items.label', 'ASC' )
		                   ->get()
		                   ->pluck( 'label', 'id' )
		                   ->toArray();
	}
}
