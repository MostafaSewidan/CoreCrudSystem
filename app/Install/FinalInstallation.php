<?php

namespace App\Install;

use Illuminate\Support\Facades\Artisan;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;

class FinalInstallation
{
    public function setup($request)
    {
        $this->createStorageFolder();
        $this->migrateDatabase();
        $this->setEnvVariables($request);
    }

    private function setEnvVariables($request)
    {
        $env = DotenvEditor::load();

        $env->setKey('APP_NAME'   , $request['app']['app_name'] , '' , false);

        $env->save();
    }

    private function migrateDatabase()
    {
        Artisan::call('migrate', ['--force' => true]);
    }

    private function createStorageFolder()
    {
        Artisan::call('storage:link');
    }
}
