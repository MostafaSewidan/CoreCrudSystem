<?php

namespace Modules\Core\Traits\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Modules\Core\Traits\DataTable;

trait CrudDashboardController
{
    use ControllerSetterAndGetter , ControllerResponse;

    function __construct() {

        $this->setViewPath();
        $this->setResource();
        $this->setModel();
        $this->setRepository();
        $this->setRequest();
    }

    /**
     * @param $view_name
     * @param array $params
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    protected function view($view_name , $params = [])
    {
        return view()->exists($this->view_path  .'.'. $view_name) ?
            view($this->view_path  .'.'. $view_name , $params):
            view($this->default_view_path  .'.'. $view_name , $params)->render();
    }

    public function index()
    {
        $model = $this->model;
        return $this->view('index',compact('model'));
    }

    public function show($id)
    {
        $model = $this->repository->findById($id);
        return $this->view('show',compact('model'));
    }


    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->repository->QueryTable($request));

        $resource = $this->model_resource;
        $datatable['data'] = $resource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function export(Request $request)
    {
        $data = $this->datatable($request);
        return $this->repository->createPDF($data->getData()->data);
    }

    public function selectSearch(Request $request)
    {
        $query = $this->repository->QueryTable($request);
        $counter = $query->count();
        $resource = $this->select_search_resource;
        $response['items'] = $resource::collection($query->get());
        $response['total_count'] = $counter;
        return Response()->json($response);
    }

    public function create()
    {
        $model = $this->model;
        return $this->view('create',compact('model'));
    }

    public function store()
    {
        $request = App::make($this->request);

        try {
            $create = $this->repository->create($request);

            if ($create) {
                return $this->createdResponse($create , [true , __('apps::dashboard.messages.created')]);
            }

            return $this->createError($create , [false  , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {

            return $this->createError(null , [false, $e->errorInfo[2]]);
        }
    }

    public function edit($id)
    {
        $model = $this->repository->findById($id);

        return $this->view('edit', compact('model'));
    }

    public function update(Request $request, $id)
    {
        $request = App::make($this->request);

        try {
            $update = $this->repository->update($request,$id);

            if ($update) {
                return $this->updatedResponse($update , [true , __('apps::dashboard.messages.updated')]);
            }

            return $this->updateError($update , [false  , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {

            return $this->updateError(null , [false, $e->errorInfo[2]]);
        }
    }

    public function destroy($id)
    {
        try {
            $delete = $this->repository->delete($id);

            if ($delete) {
                return Response()->json([true , __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([false  , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deletes(Request $request)
    {
        try {
            $deleteSelected = $this->repository->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true , __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([false  , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function switcher($id, $action)
    {
        try{
            $switch = $this->repository->switcher($id,$action);

            if ($switch) {
                return Response()->json();
            }

            return Response()->json([false  , __('apps::dashboard.messages.failed')],400);

        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }


    public function deleteAttachment($model ,$collection, $media)
    {
        try {
            $delete = $this->repository->deleteAttachment($model ,$collection, $media);

            if ($delete) {
                return Response()->json([true , __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([true , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
