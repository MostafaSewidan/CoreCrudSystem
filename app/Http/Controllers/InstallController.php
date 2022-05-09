<?php

namespace App\Http\Controllers;

use App\Http\Middleware\RedirectIfNotInstalled;
use Exception;
use App\Install\App;
use App\Install\Database;
use App\Install\Requirement;
use App\Install\AdminAccount;
use App\Install\FinalInstallation;
use Illuminate\Routing\Controller;
use App\Http\Requests\InstallAppRequest;
use App\Http\Requests\InstallDatabaseRequest;
use Illuminate\Support\Facades\Artisan;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;

class InstallController extends Controller
{
    public function __construct()
    {
        $this->middleware(RedirectIfNotInstalled::class);
    }

    public function installation(Requirement $requirement)
    {
        return view('install.new', compact('requirement'));
    }

    public function configurations(Requirement $requirement)
    {
        if (!$requirement->satisfied()) {
            return redirect()->name('installation');
        }

        return redirect(route('view.db.configurations'));
    }

    public function viewDb(Requirement $requirement)
    {
        return view('install.db_configuration', compact('requirement'));
    }

    public function db(InstallDatabaseRequest $request, Database $database, App $app)
    {
        $database->setup($request->db);
        $app->setup($request);

        return redirect()->route('app.view.installation');
    }

    public function viewApp()
    {
        return view('install.app_configuration');
    }

    public function app(InstallAppRequest $request, FinalInstallation $final, AdminAccount $admin)
    {
        $final->setup($request);
        $admin->setup($request);

        return redirect()->route('complete.installation');
    }

    public function complete()
    {
        if (env('APP_INSTALLED') && env('APP_INSTALLED') == true) {
            return redirect()->route('dashboard.home');
        }

        $env = DotenvEditor::load();
        $env->setKey('APP_INSTALLED', true);
        $env->save();
        Artisan::call('config:cache');
        Artisan::call('config:clear');

        return view('install.complete');
    }
}
