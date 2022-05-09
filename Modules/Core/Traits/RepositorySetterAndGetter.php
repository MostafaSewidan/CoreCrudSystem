<?php

namespace Modules\Core\Traits;


trait RepositorySetterAndGetter
{
    protected $model;

    protected function getTableName()
    {
        return $this->model->getTable();
    }

    public function getModel()
    {
        return $this->model;
    }

    public function getModelTranslatable()
    {
        if(property_exists($this->model,'translatable')){
            return $this->model->translatable;
        }else{
            return [];
        }
    }
}
