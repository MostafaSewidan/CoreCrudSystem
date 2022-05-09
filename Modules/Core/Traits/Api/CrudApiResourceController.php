<?php

namespace Modules\Core\Traits\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

trait CrudApiResourceController
{
    protected $repository;
    protected $model_resource;
    protected $storeRequest;
    protected $updateRequest;

    /**
     * @param mixed $repository
     */
    public function setRepository($repository): void
    {
        $this->repository = $repository;
    }

    /**
     * @return mixed
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @param mixed $model_resource
     */
    public function setModelResource($model_resource): void
    {
        $this->model_resource = $model_resource;
    }

    /**
     * @return mixed
     */
    public function getModelResource()
    {
        return $this->model_resource;
    }

    /**
     * @param mixed $storeRequest
     */
    public function setStoreRequest($storeRequest): void
    {
        $this->storeRequest = $storeRequest;
    }

    /**
     * @return mixed
     */
    public function getStoreRequest()
    {
        return $this->storeRequest;
    }

    /**
     * @param mixed $updateRequest
     */
    public function setUpdateRequest($updateRequest): void
    {
        $this->updateRequest = $updateRequest;
    }

    /**
     * @return mixed
     */
    public function getUpdateRequest()
    {
        return $this->updateRequest;
    }

    public function index(Request $request)
    {
        $records = $this->repository->getPagination($request);
        $resource = $this->model_resource;

        return $resource::collection($records);
    }

    public function show($id)
    {
        $resource = $this->model_resource;
        $model = $this->repository->findById($id);

        return response()->json(['data' => new $resource($model)]);
    }

    public function store()
    {
        $request = App::make($this->storeRequest);

        try {
            $model = $this->repository->create($request);

            if ($model) {
                $resource = $this->model_resource;
                return response()->json(['data' => new $resource($model)]);
            }

            return response()->json(['message' => __('apps::api.messages.failed')], 400);
        } catch (\PDOException $e) {

            return response()->json(['message' => $e->errorInfo[2]], 400);
        }
    }

    public function update($id)
    {
        $request = App::make($this->updateRequest);

        try {
            $model = $this->repository->update($request, $id);

            if ($model) {
                $resource = $this->model_resource;
                return response()->json(['data' => new $resource($model)]);
            }

            return response()->json(['message' => __('apps::api.messages.failed')], 400);
        } catch (\PDOException $e) {

            return response()->json(['message' => $e->errorInfo[2]], 400);
        }
    }

    public function destroy($id)
    {
        try {
            $delete = $this->repository->delete($id);

            if ($delete) {
                return response()->json(['message' => __('apps::api.messages.deleted')]);
            }

            return response()->json(['message' => __('apps::api.messages.failed')], 400);
        } catch (\PDOException $e) {

            return response()->json(['message' => $e->errorInfo[2]], 400);
        }
    }
}
