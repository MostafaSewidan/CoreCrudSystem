<?php
namespace Modules\Core\Packages\Setting;

use Cache;
use Spatie\Valuestore\Valuestore;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Traits\ForwardsCalls;

class SettingJsonService implements SettingManager
{
    use ForwardsCalls;

    /**
     * @var Valuestore
     */
    private $store;

    /**
    * The name of the sttings file.
    *
    * @var string
    */
    private $fileName = "settings.json";


    /**
     * Constructor.
     */
    public function __construct()
    {
        if (!Storage::exists($this->fileName)) {
            file_put_contents(storage_path("app/{$this->fileName}"), json_encode($this->defaultValues()));
        }
        $this->store = Valuestore::make(storage_path("app/{$this->fileName}"));
    }

    public function get($key, $default = null)
    {
        return  $this->store->get($key, $default);
    }

    public function put($key, $value)
    {
        return $this->store->put($key, $value);
    }
    
    public function all()
    {
        return  $this->store->all();
    }

    public function flush()
    {
        return  $this->store->flush();
    }

    public function forget($key)
    {
        return  $this->store->forget($key);
    }

    /**
     * Handle dynamic method calls into the service.
     *
     * @param string $method     Name of the method being called.
     * @param array  $parameters List of parameters passed to the method.
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->forwardCallTo($this->store, $method, $parameters);
    }
    

    /**
     * Provide the default values for the settings.
     *
     * @return array
     */
    private function defaultValues()
    {
        return [
            "locales" => ["ar","en"],
            "rtl_locales" => ["ar"],
            "default_locale" => "ar",
            "currencies" => ["KWD"],
            "default_currency" => "KWD",
            "app_name" => [
                "ar" => "App" ,
                "en" => "app"
            ],
            "other" => [
                "about_us" => "" ,
                "terms"    => ""
            ]
        ];
    }
}
