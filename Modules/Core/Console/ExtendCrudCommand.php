<?php

namespace Modules\Core\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Modules\Core\Traits\Commands\CrudCreator;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ExtendCrudCommand extends Command
{
    use CrudCreator;
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'extend:crud';

    protected $signature = 'extend:crud {model} {module}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private function getFolderName()
    {
        return $this->getPath($this->argument('model'));
    }

    private function getPath($path)
    {
        $array = explode('/', $path);
        unset($array[count($array) - 1]);
        return implode('/', $array);
    }

    private function getModelName()
    {
        $array = explode('/', $this->argument('model'));
        return $array[count($array) - 1];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->setModuleName($this->argument('module'));
        $this->setModelName($this->getModelName());
        $this->setFolderName($this->getFolderName());

        $paths = $this->getPaths();
        $namesPaces = $this->getNameSpaces();
        $classes = $this->getClassNames();
        $route = $this->getRoutesName();

        foreach ($paths as $key => $path) {

            if ($this->confirm('Create ' . $key . ' class in ' . $path, true)) {

                if (!File::isDirectory($this->getPath($path)))
                    File::makeDirectory($this->getPath($path), 0755, true, true);

                File::put($path, $this->buildClass($key, $namesPaces[$key], $classes[$key]));
                $this->info('Created : ' . $path);
            }
        }

        if ($this->confirm('Create route file in ' . $route, true)) {

            if (!File::isDirectory($this->getPath($route)))
                File::makeDirectory($this->getPath($route), 0755, true, true);

            File::put($route, $this->buildRoute($classes['controller']));
            $this->info('Created : ' . $route);
        }

        $this->info('Your crud system is generated successfully!');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['model', InputArgument::REQUIRED, 'the model name is required.'],
            ['module', InputArgument::REQUIRED, 'the module name is required.'],
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
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
