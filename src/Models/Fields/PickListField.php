<?php

namespace Foundry\Models\Fields;

use Foundry\Models\PickListItem;

/**
 * Interface Pick List Options
 *
 * Fetches a list of options from the pick lists
 *
 * @package Foundry\Models
 */
abstract class PickListField extends ChoiceField {

	/**
	 * The input options
	 *
	 * @param string $identifier The identifier to get the list items
	 *
	 * @return array
	 */
	static function list( $identifier ): array {
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