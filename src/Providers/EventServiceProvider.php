<?php

namespace Foundry\Providers;

use Foundry\Models\Setting;
use Foundry\Observers\SettingObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [

    ];

    /**
     * Register any other events for your application.

     * @return void
     */
    public function boot()
    {
        parent::boot();

        Setting::observe(new SettingObserver());
    }
}
