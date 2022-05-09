<?php

namespace App\Install;

use Illuminate\Support\Facades\Artisan;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;

class App
{
    public function setup($request)
    {
        $this->generateAppKey();
        $this->setEnvVariables($request);
        $this->setAppSettings($request);
    }

    private function generateAppKey()
    {
        Artisan::call('key:generate', ['--force' => true]);
    }

    private function setEnvVariables($request)
    {
        $env = DotenvEditor::load();

        $env->setKey('APP_ENV', 'local');
        $env->setKey('APP_DEBUG', 'true');
        $env->setKey('APP_URL', url('/'));

        $env->save();
    }

    private function setAppSettings($request)
    {
        app('setting')->put([
            'app_name' => [
                'en' => $request['app']['app_name'],
            ],
            'locales' => [
                'en', 'ar'
            ],
            'default_locale' => 'ar',
            'rtl_locales' => [
                'ar'
            ],
            'logo' => '/uploads/default.png',
            'footer_logo' => '/uploads/default.png',
            'favicon' => '/uploads/default.png',
        ]);
    }
}
