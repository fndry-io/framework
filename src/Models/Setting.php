<?php

namespace Foundry\Models;

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
 *
 * @package Foundry\Models
 */
class Setting extends Model{

    use SoftDeletes;

    //Possible values for the type field
    static $types = [
        'bool' => 'bool',
        'int' => 'int',
        'integer' => 'integer',
        'boolean' => 'boolean',
        'string' => 'string',
        'double' => 'double',
        'array' => 'array'
    ];

    /**
     * Various properties of the respective setting
     *
     * e.g '{$domain}.{$name}' => array('description' => 'Human readable description', 'default' => '{$default}', 'type' => '{$type[i]}', 'options' => 'array of available options')
     *
     * @var array
     */
    static $settings = [

    ];

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

}
