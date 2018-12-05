<?php

namespace Foundry\Observers;


use Foundry\Config\SettingRepository;
use Foundry\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SettingObserver{

    /**
     * Refresh settings cache
     */
    public function saved()
    {
        $settings = self::getSettingsItems();
        Cache::put('settings', $settings, now()->addDays(30));

        setting()->set($settings);
    }

    /**
     * Get all settings values
     *
     * @return array
     */
    static function getSettingsItems(): array
    {

        $table = SettingRepository::getTable();

        $settings = DB::table($table)->get();

        $arr = array();

        /**@var $setting Setting*/
        foreach ($settings as $setting){

            $value = $setting->value? $setting->value : $setting->default;

            settype($value, isset($setting->type)? $setting->type: 'string');

            $arr[$setting->domain.'.'.$setting->name] = $value;
        }

        return $arr;
    }
}
