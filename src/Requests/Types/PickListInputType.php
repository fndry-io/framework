<?php

namespace Foundry\Requests\Types;


class PickListInputType extends ChoiceInputType {

	/**
	 * The input options
	 *
	 * @param string $identifier The identifier to get the list items
	 *
	 * @return array
	 */
	static function list( $identifier ): array {
		return config('foundry.pick-list-items.model')::query()
		                   ->select( [ 'pick_list_items.*' ] )
		                   ->join( 'pick_lists', 'pick_list_items.pick_list_id', '=', 'pick_lists.id' )
		                   ->where( 'pick_list_items.status', 1 )
		                   ->where( 'pick_lists.identifier', $identifier )
		                   ->orderBy( 'pick_list_items.label', 'ASC' )
		                   ->get()
		                   ->pluck( 'label', 'id' )
		                   ->toArray();
	}

	static function cast($item)
	{
		if ($item->isMultiple()) {
			return 'array_int';
		} else {
			return 'int';
		}
	}

}
