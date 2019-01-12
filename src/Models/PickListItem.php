<?php

namespace Foundry\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Pick List Item Model
 * 
 * @property int $id
 * @property string $label
 * @property string $description
 * @property string $identifier
 * @property boolean $status
 * @property boolean $default
 * @property int $pick_list_id
 * @property PickList $list
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 *
 * @package Foundry\Core\Models
 */
class PickListItem extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pick_list_items';

	protected $primaryKey = 'id';

	protected $casts = [
		'id' => 'integer'
	];

	protected $fillable = [
		'label',
		'description',
		'identifier',
		'status',
		'default',
        'pick_list_id'
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

    /**
     * Get the list
     */
    public function list()
    {
        return $this->belongsTo(PickList::class, 'pick_list_id');
    }

}
