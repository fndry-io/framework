<?php

namespace Foundry\Core\Models;

use Foundry\Core\Models\Events\SettingSaved;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Setting
 *
 * @property $domain
 * @property $name
 * @property $type
 * @property $default
 * @property $value
 * @property $model
 *
 * @package Foundry\Models
 */
class Setting extends Model {

	use SoftDeletes;

	//Possible values for the type field
	static $types = [
		'bool'    => 'bool',
		'int'     => 'int',
		'integer' => 'integer',
		'boolean' => 'boolean',
		'string'  => 'string',
		'double'  => 'double',
		'array'   => 'array'
	];

	/**
	 * Get fully qualified class name for the model
	 * Needs to be overridden in child class
	 *
	 * @return string
	 */
	static function model(): string {
		return get_class( New Setting() );
	}

	/**
	 * Various properties of the respective setting
	 *
	 * e.g '{$domain}.{$name}' => array('description' => 'Human readable description', 'default' => '{$default}', 'type' => '{$type[i]}', 'options' => 'array of available options')
	 *
	 * @return array
	 */
	static function settings(): array {
		return [];
	}

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'domain',
		'name',
		'type',
		'default',
		'value'
	];

	protected $dates = [
		'created_at',
		'deleted_at',
		'updated_at'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'created_at',
		'updated_at',
		'deleted_at'
	];

	protected $guarded = [

	];

	/**
	 * The event map for the model.
	 *
	 * @var array
	 */
	protected $dispatchesEvents = [
		'saved' => SettingSaved::class,
	];

	/**
	 * Get the original description for a setting
	 *
	 * @return mixed|string
	 */
	public function getDescriptionAttribute()
	{
		$class = $this->model;
		$settings = call_user_func([$class, 'settings']);
		$s = isset($settings[$this->domain.'.'.$this->name]) ? $settings[$this->domain.'.'.$this->name]: [];
		return isset($s['description'])? $s['description'] : 'N/A';
	}

}
