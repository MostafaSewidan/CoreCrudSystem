<?php

namespace Modules\Core\Traits\Commands;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait CrudCreator
{
    protected $folder;
    protected $module;
    protected $model;
    protected $stub_route = 'routes';

    protected $paths = [
        'controller' => 'Modules/::module/Http/Controllers/::folder/::modelController.php',
        'request' => 'Modules/::module/Http/Requests/::folder/::modelRequest.php',
        'repository' => 'Modules/::module/Repositories/::folder/::modelRepository.php',
        'resource' => 'Modules/::module/Transformers/::folder/::modelResource.php',
    ];

    protected $class_names = [
        'controller' => '::modelController',
        'request' => '::modelRequest',
        'repository' => '::modelRepository',
        'resource' => '::modelResource',
    ];

    protected $nameSpaces = [
        'controller' => 'Modules\::module\Http\Controllers\::folder',
        'request' => 'Modules\::module\Http\Requests\::folder',
        'repository' => 'Modules\::module\Repositories\::folder',
        'resource' => 'Modules\::module\Transformers\::folder',
    ];

    protected $route = 'Modules/::module/Routes/::folder/::model.php';
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @return mixed
     */
    protected function getModuleName()
    {
        return $this->module;
    }

    /**
     * @param $name
     */
    protected function setModuleName($name)
    {
        $this->module = Str::ucfirst($name);
    }

    /**
     * @param $name
     */
    protected function setModelName($name)
    {
        $this->model = Str::ucfirst($name);
    }

    /**
     * @param $name
     */
    protected function setFolderName($name)
    {
        $this->folder = $name;
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStubDir()
    {
        return base_path() . '/Modules/Core/stubs/dashboard';
    }

    /**
     * @param $name
     * @return string
     */
    protected function getStub($name)
    {
        return $this->getStubDir() . '/' . $name . '.stub';
    }

    /**
     * @param $folder
     * @param $file
     * @return string
     */
    protected function getNewPath($file)
    {
        $path = array_key_exists($file, $this->paths) ?
            base_path(Str::replace(['::module', '::folder','::model'], [$this->module, $this->folder , $this->model], $this->paths[$file])) : '';

        return $path;
    }

    /**
     * @param $folder
     * @param $file
     * @return string
     */
    protected function getNameSpace($file)
    {
        $nameSpace = array_key_exists($file, $this->nameSpaces) ?
            Str::replace(
                ['::module', '::folder'],
                [$this->module, Str::replace('/' , '\\',$this->folder)],
                $this->nameSpaces[$file]) : '';

        return $nameSpace;
    }

    protected function getPaths()
    {
        $paths = [];

        foreach ($this->paths as $file => $path) {
            $paths += [$file => $this->getNewPath($file )];
        }

        return $paths;
    }

    protected function getNameSpaces()
    {
        $nameSpaces = [];

        foreach ($this->nameSpaces as $file => $nameSpace) {
            $nameSpaces += [$file => $this->getNameSpace($file)];
        }

        return $nameSpaces;
    }

    protected function getClassNames()
    {
        $classes = [];

        foreach ($this->class_names as $file => $class_name) {
            $classes += [$file => Str::replace('::model', $this->model, $class_name)];
        }

        return $classes;
    }

    protected function getRoutesName()
    {
       return Str::replace(
           ['::module', '::folder','::model'],
           [$this->module, $this->folder , Str::plural(strtolower($this->model))], $this->route);
    }

    protected function buildClass($folder, $nameSpace, $class)
    {
        $stub = File::get($this->getStub($folder));
        return Str::replace(['{{ namespace }}', '{{ class }}'], [$nameSpace, $class], $stub);
    }

    protected function buildRoute($controller)
    {
        $stub = File::get($this->getStub($this->stub_route));
        return Str::replace(['{{ route }}', '{{ controller }}'], [Str::plural(Str::lower($this->model)), $controller], $stub);
    }
}
