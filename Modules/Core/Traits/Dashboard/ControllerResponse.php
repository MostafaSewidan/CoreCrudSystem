<?php

namespace Modules\Core\Traits\Dashboard;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Modules\Core\DataTables\DefaultDataTable;
use Modules\Core\Repositories\Dashboard\CrudRepository;

trait ControllerResponse
{
    protected function createdResponse($model , $data){

        return Response()->json($data);
    }

    protected function createError($model , $data){

        return Response()->json($data);
    }

    protected function updatedResponse($model , $data){

        return Response()->json($data);
    }

    protected function updateError($model , $data){

        return Response()->json($data);
    }
}
