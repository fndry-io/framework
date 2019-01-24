<?php

namespace Foundry\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $state
 * @property string $comment
 * @property string $stateable_type
 * @property integer $stateable_id
 * @property string $created_at
 * @property string $updated_at
 */
abstract class State extends Model {

	protected $table = 'states';

	/**
	 * @var array
	 */
	protected $fillable = [
		'state',
		'comment',
		'stateable_type',
		'stateable_id'
	];

	/**
	 * Get all of the owning stateable models.
	 */
	public function stateable()
	{
		return $this->morphTo();
	}
}
