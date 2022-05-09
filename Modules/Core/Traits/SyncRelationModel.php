<?php

namespace Modules\Core\Traits;

trait SyncRelationModel
{

    public function syncRelation($model , $relation , $arrayValues = null)
    {
        $oldValuesForm = array_keys(array_filter($arrayValues));

        $oldIds = $model->$relation->pluck('id')->toArray();

        $data['deleted'] = array_values(array_diff($oldIds,$oldValuesForm));

        $data['updated'] = array_values(array_intersect($oldIds,$oldValuesForm));

        return $data;
    }
}
