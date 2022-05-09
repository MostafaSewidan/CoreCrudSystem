<?php
namespace Modules\Core\Packages\Setting;

use Illuminate\Support\Facades\Facade;
use Modules\Core\Packages\Setting\SettingManager;

class Setting extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return SettingManager::class; }
}
