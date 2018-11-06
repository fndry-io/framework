<?php

namespace Foundry\Providers;

use Foundry\Console\Commands\GenerateModelCommand;
use Illuminate\Support\ServiceProvider;

/**
 * Class ConsoleServiceProvider
 *
 * @package Foundry\Providers
 *
 * @author Medard Ilunga
 */
class ConsoleServiceProvider extends ServiceProvider
{
    protected $defer = false;

    /**
     * The available commands
     *
     * @var array
     */
    protected $commands = [
        GenerateModelCommand::class,
    ];

    /**
     * Register the commands.
     */
    public function register()
    {
        $this->commands($this->commands);
    }

    /**
     * @return array
     */
    public function provides()
    {
        $provides = $this->commands;

        return $provides;
    }
}
