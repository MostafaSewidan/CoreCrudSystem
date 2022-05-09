<?php

namespace Modules\Core\Traits\Dashboard;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Modules\Core\DataTables\DefaultDataTable;
use Modules\Core\Repositories\Dashboard\CrudRepository;

trait ControllerSetterAndGetter
{
    protected $repository;
    protected $view_path;
    protected $default_view_path = 'core::dashboard.default-views';
    protected $model_resource;
    protected $select_search_resource;
    protected $model;
    protected $dataTable;
    protected $request;
    protected $folder = 'dashboard';

    protected function setRepository($repository = null)
    {
        if ($repository) {

            $this->repository = new $repository($this->model);

        } else {

            $class = $this->buildNameSpace('Repositories', 'Repository');

            if (class_exists($class)) {

                $this->repository = new $class($this->model);
            } else {

                $this->repository = new CrudRepository($this->model);
            }
        }
    }

    protected function setViewPath($view = null)
    {
        if ($view) {
            $this->view_path = $view;

        } else {
            $class = get_called_class(); // or $class = static::class;
            $class = str_replace('Controller', '', $class);
            $arr_class = explode("\\", $class);
            $module_name = strtolower($arr_class[1]);
            $view_name = strtolower($arr_class[count($arr_class) - 1]);
            $this->view_path = $module_name . '::'.$this->folder.'.' . Str::plural($view_name);
        }

    }

    protected function setRequest($request = null)
    {
        if ($request) {
            $this->request = $request;
        } else {
            $class = $this->buildNameSpace('Http\Requests', 'Request');
            if (class_exists($class)) {

                $this->request = $class;
            } else {

                $this->request = 'Modules\Core\Http\Requests\''.Str::ucfirst($this->folder).'\DefaultRequest';
            }
        }

    }

    protected function setResource($resource = null)
    {
        if ($resource) {
            $this->model_resource = get_class($resource);
        } else {

            $class = $this->buildNameSpace('Transformers', 'Resource');

            if (class_exists($class)) {

                $this->model_resource = $class;
            } else {

                $this->model_resource = 'Modules\Core\Transformers\''.Str::ucfirst($this->folder).'\DefaultResource';
            }
        }

    }

    protected function setModel($model = null)
    {
        if ($model) {
            $this->model = new $model;
            $this->setRepository();
        } else {
            $class = $this->buildNameSpace('Entities', '', false);
            if (class_exists($class)) {

                $this->model = new $class;
            }
        }
    }

    protected function setDataTable()
    {
        $class = $this->buildNameSpace('DataTables', 'DataTable', false);

        if (class_exists($class)) {

            $this->dataTable = new $class;
        } else {
            $this->dataTable = new DefaultDataTable;
        }
    }

    protected function getTargetMethod()
    {
        $class = get_called_class();
        $action = explode('@', Route::getCurrentRoute()->getActionName());
        $method = end($action);

        if (!method_exists($class, $method)) {
            $crud_method = 'crud_' . $method;
            $this->$crud_method();
        }
    }

    /**
     * @param $folder
     * @param $file_tail
     * @param bool $dashboard_folder
     * @return mixed|string
     */
    private function buildNameSpace($folder, $file_tail, $dashboard_folder = true)
    {
        $class = get_called_class();
        $class = str_replace('Http\Controllers', $folder, $class);

        if (!$dashboard_folder)
            $class = str_replace(Str::ucfirst($this->folder).'\\', '', $class);

        $class = str_replace('Controller', $file_tail, $class);

        return $class;
    }
}
