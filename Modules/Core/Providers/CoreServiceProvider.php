<?php

namespace Modules\Core\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Schema;
use Modules\Core\Console\CreateCrudes;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Console\ExtendCrudCommand;
use Modules\Core\Listeners\ModuleMaked;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Console\Events\CommandFinished;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Packages\Setting\SettingManager;
use Modules\Core\Providers\ConfigServiceProvider;
use Modules\Core\Packages\Setting\SettingJsonService;

class CoreServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration;
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->registerCommands();
        $this->loadMigrationsFrom(module_path('Core', 'Database/Migrations'));
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishConfig('core', 'available-locales');
        $this->publishConfig('core', 'config');
    }

     /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        // bind
        $this->app->singleton(SettingManager::class, SettingJsonService::class);

    }


    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/core');

        $sourcePath = module_path('Core', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/core';
        }, \Config::get('view.paths')), [$sourcePath]), 'core');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/core');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'core');
        } else {
            $this->loadTranslationsFrom(module_path('Core', 'Resources/lang'), 'core');
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(module_path('Core', 'Database/factories'));
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerCommands()
    {
        $this->commands([
            ExtendCrudCommand::class
        ]);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
