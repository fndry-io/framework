<?php
namespace Foundry\Seeders\Concerns;

use Foundry\Models\PickList;
use Foundry\Models\PickListItem;

trait PickListSeed {

	public function seedPickList($list, $items)
	{
		if (!$list = PickList::where('identifier', $list['identifier'])->first()) {
			$list = new PickList();
			$list->identifier = $list['identifier'];
			$list->label = $list['label'];
			$list->save();
		}

		foreach ($items as $_item) {
			if (!$item = PickListItem::where('identifier', $_item['identifier'])->where('pick_list_id', $list->id)->first()) {
				$item = new PickListItem();
				$item->identifier = $_item['identifier'];
				$item->label = $_item['label'];
				$item->status = $_item['status'];
				$item->pick_list_id = $list->id;
				$item->save();
			}
		}
	}

}