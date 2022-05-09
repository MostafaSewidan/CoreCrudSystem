<?php

namespace Modules\Core\Traits\Dashboard;

use Modules\Core\Traits\ScopesTrait;
use Spatie\Activitylog\Traits\LogsActivity;

trait QueryActions
{
    public function QueryPrint($query)
    {
        return $this->view('index');
    }
}
