<?php
namespace Modules\Core\Packages\Setting;

interface SettingManager
{
   public function get($key, $default=null);
   public function put($key, $value);
   public function all();
   public function forget($key);
   public function flush();
}
