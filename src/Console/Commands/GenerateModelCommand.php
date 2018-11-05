<?php

namespace Foundry\Console\Commands;


use Symfony\Component\Console\Input\InputArgument;

class GenerateModelCommand extends BaseCommand
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'foundry:model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new model';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $module = $this->laravel['modules']->findOrFail($this->argument('module'));

        if ($module->enabled()) {
            $this->info("Module [{$module}] is enabled.");
        } else {
            $this->comment("Module [{$module}] is disabled.");
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['module', InputArgument::REQUIRED, 'Module name.'],
        ];
    }
}
