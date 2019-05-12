<?php

namespace Foundry\Core\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * Log Model
 *
 * @property string $level
 * @property string $description
 * @property string $ip
 * @property integer $user_id
 * @property string $session
 * @property string $origin
 * @property string $user_agent
 *
 * @package Foundry\Models
 */
class Log extends Model {

	protected $table = 'logs';

	protected $fillable = [
		'type',
		'result',
		'level',
		'description',
		'url',
		'origin',
		'user_id',
		'ip',
		'user_agent',
		'session'
	];

	/**
	 * @var array $guarded
	 */
	protected $guarded = [
		'id'
	];

	/**
	 * Log a record to the database
	 *
	 * @param $record
	 *
	 * @return bool
	 */
	static public function saveRecord($record)
	{
		$log = new static();
		$log->fill($record['formatted']);
		return $log->save();
	}


}