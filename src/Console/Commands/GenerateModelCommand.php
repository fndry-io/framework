<?php

namespace Foundry\Console\Commands;


use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

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
        $this->call('module:make-model', array(
            'module' => $this->argument('plugin'),
            'model' => $this->argument('model'),
            '-m' => true
        ));

        $this->call('module:make-request', array(
            'name' => $this->argument('model'),
            'module' => $this->argument('plugin'),
        ));

        $this->call('foundry:service', array(
            'service' => $this->argument('model'),
            'module' => $this->argument('plugin'),
        ));
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['model', InputArgument::REQUIRED, 'The name of the model that will be created.'],
            ['plugin', InputArgument::OPTIONAL, 'The name of the plugin that will be used.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['fillable', null, InputOption::VALUE_OPTIONAL, 'The fillable attributes.', null],
        ];
    }

    /**
     * Get template contents.
     *
     * @return string
     */
    protected function getTemplateContents()
    {
        // TODO: Implement getTemplateContents() method.
    }

    /**
     * Get the destination file path.
     *
     * @return string
     */
    protected function getDestinationFilePath()
    {
        // TODO: Implement getDestinationFilePath() method.
    }
}
