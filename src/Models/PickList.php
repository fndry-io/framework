<?php

namespace Foundry\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Pick List Model
 *
 * @property int $id
 * @property string $label
 * @property string $description
 * @property string $identifier
 * @property PickListItem[] $items The collection of items for this pick list
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 *
 * @package Foundry\Core\Models
 */
class PickList extends Model {
	use SoftDeletes;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'pick_lists';

	protected $primaryKey = 'id';

	protected $casts = [
		'id' => 'integer',
	];

	protected $fillable = [
		'label',
		'description',
		'identifier'
	];

	/**
	 * Dates
	 * @var array
	 */
	protected $dates = [
		'deleted_at',
		'created_at',
		'updated_at'
	];


	public function __construct( array $attributes = [] ) {
		$this->table = config('foundry.pick-lists.table');
		parent::__construct( $attributes );

	}

	/**
	 * Get list items
	 */
	public function items() {
		return $this->hasMany( config('foundry.pick-list-items.model') )->orderBy('status', 'DESC')->orderBy('label', 'ASC');
	}
}
