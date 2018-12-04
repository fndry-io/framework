<?php

namespace Foundry\Seeders;

use Illuminate\Database\Seeder;
use Foundry\Config\SettingRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Plugins\Foundry\Users\Models\Setting;

abstract class SettingSeeder extends Seeder{

    /**
     * @return array
     */
    protected abstract function getSettings() : array;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info(sizeof($this->getSettings()));

        $table = SettingRepository::getTable();

        if(!Schema::hasTable($table)){
            Artisan::call('migrate');
        }

        $illegal = 0;

        foreach ($this->getSettings() as $key => $setting){

            $domain_name = explode('.', $key);

            if(sizeof($domain_name) === 2){

                //Check if setting with given domain and name exists
                $model = DB::table($table)->where('domain', $domain_name[0])
                                          ->where('name', $domain_name[1])->first();

                //If no model exists, create new one
                if(!$model)
                    $model = new Setting();

                $model->domain = $domain_name[0];
                $model->name = $domain_name[1];
                $type = isset($setting['type'])? $setting['type']: 'string';

                $model->type = $type;
                $model->default = isset($setting['default'])? $setting['default']: $this->getDefaultBasedOnType($type);

                $model->save();

            }else{
                $illegal += 1;
            }

        }


        if($illegal > 0){
            $this->command->error('There were '. $illegal. ' settings with illegal names');
        }

    }

    private function getDefaultBasedOnType($type){
        switch ($type){
            case 'int':
            case 'integer':
                return 1;
                break;
            case 'string':
                return '';
                break;
            case 'array':
                return [];
                break;
            case 'bool':
            case 'boolean':
                return 0;
                break;
        }
    }
}
