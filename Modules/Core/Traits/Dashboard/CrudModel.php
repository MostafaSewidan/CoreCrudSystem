<?php

namespace Modules\Core\Traits\Dashboard;

use Modules\Core\Traits\ScopesTrait;
use Spatie\Activitylog\Traits\LogsActivity;

trait CrudModel
{
    use ScopesTrait, LogsActivity;
    public $timestamps = true;
    protected static $logAttributes = [];
    protected static $logOnlyDirty = true;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setLogAttributes();
    }

    protected function setLogAttributes($logAttributes = null){

        if($logAttributes){
            self::$logAttributes = $logAttributes;
        }else{

            if(!count(self::$logAttributes)) {
                self::$logAttributes = $this->fillable;
            }
        }
    }
    public function getGuardName()
    {
        return $this->guard_name;
    }
}
