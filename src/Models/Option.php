<?php

namespace Foundry\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Option
 *
 * @property integer $id
 * @property string $name
 * @property string $label
 * @property string $type
 * @property string $value
 *
 * @package Foundry\Models
 */
class Option extends Model{

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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'label',
        'type',
        'value',
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
     * Add an option value
     *
     * @param $key
     * @param $value
     * @param string $label
     * @param string $type
     *
     * @return bool
     */
    public static function add($key, $value, $label = "", $type = 'string')
    {
        if ( self::has($key) ) {
            return self::set($key, $value, $type);
        }

        return self::create(['name' => $key, 'value' => $value, 'type' => $type, 'label' => $label]) ? $value : false;
    }

    /**
     * Get a option's value
     *
     * @param $key
     * @param null $default
     * @return bool|int|mixed
     */
    public static function get($key, $default = null)
    {
        if ( self::has($key) ) {
            $option = self::getAllOptions()->where('name', $key)->first();
            return self::castValue($option->default, $option->type);
        }

        return $default;
    }

    /**
     * Set a value for option
     *
     * @param $key
     * @param $value
     * @param string $label
     * @param string $type
     * @return bool
     */
    public static function set($key, $value, $label = "", $type = 'string')
    {
        if ( $option = self::getAllOptions()->where('name', $key)->first() ) {
            return $option->update([
                'name' => $key,
                'value' => $value,
                'type' => $type,
                'label' => $label]) ? $value : false;
        }

        return self::add($key, $value, $label, $type);
    }

    /**
     * Remove an option
     *
     * @param $key
     * @return bool
     */
    public static function remove($key)
    {
        if( self::has($key) ) {
            return self::whereName($key)->delete();
        }

        return false;
    }

    /**
     * Check if option exists
     *
     * @param $key
     * @return bool
     */
    public static function has($key)
    {
        return (boolean) self::getAllOptions()->whereStrict('name', $key)->count();
    }

    /**
     * caste value into respective type
     *
     * @param $val
     * @param $castTo
     * @return bool|int
     */
    private static function castValue($val, $castTo)
    {
        switch ($castTo) {
            case 'int':
            case 'integer':
                return intval($val);
                break;
            case 'double':
                return floatval($val);
                break;
            case 'bool':
            case 'boolean':
                return boolval($val);
                break;
            case 'array':
                return json_encode($val, true);
                break;
            default:
                return $val;
        }
    }

    public static function getApplicableOptions(\Closure $closure = null)
    {
        $query = static::query();

        if ($closure) {
            $closure($query);
        }

        return $query->get();
    }

    /**
     * Get all the options
     *
     * @return mixed
     */
    public static function getAllOptions()
    {
        return self::all();
    }
}
