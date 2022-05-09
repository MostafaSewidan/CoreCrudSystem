<?php

use Nwidart\Modules\Activators\FileActivator;

return [

    /*
    |--------------------------------------------------------------------------
    | Module Namespace
    |--------------------------------------------------------------------------
    |
    | Default module namespace.
    |
    */

    'namespace' => 'Modules',

    /*
    |--------------------------------------------------------------------------
    | Module Stubs
    |--------------------------------------------------------------------------
    |
    | Default module stubs.
    |
    */

    'stubs' => [
        'enabled' => false,
        'path' => base_path() . '/Modules/Core/stubs',
        'files' => [
            'package' => 'package.json',
            'scaffold/config' => 'Config/config.php',
            'composer' => 'composer.json',
            'webpack' => 'webpack.mix.js',
            'routes/dashboard/routes'   => 'Routes/dashboard/routes.php',
            'routes/frontend/routes'    => 'Routes/frontend/routes.php',
            'routes/api/routes'         => 'Routes/api/routes.php',
//            'Http/Controllers/Dashboard/Dashboardcontroller'         => 'Http/Controllers/Dashboard/Dashboardcontroller.php',
        ],
        'replacements' => [
            'routes/web' => ['LOWER_NAME', 'STUDLY_NAME'],
            'routes/api' => ['LOWER_NAME'],
            'webpack' => ['LOWER_NAME'],
            'json' => ['LOWER_NAME', 'STUDLY_NAME', 'MODULE_NAMESPACE', 'PROVIDER_NAMESPACE'],
            'views/index' => ['LOWER_NAME'],
            'views/master' => ['LOWER_NAME', 'STUDLY_NAME'],
            'scaffold/config' => ['STUDLY_NAME'],
            'composer' => [
                'LOWER_NAME',
                'STUDLY_NAME',
                'VENDOR',
                'AUTHOR_NAME',
                'AUTHOR_EMAIL',
                'MODULE_NAMESPACE',
                'PROVIDER_NAMESPACE',
            ],
        ],
        'gitkeep' => true,
    ],
    'paths' => [
        /*
        |--------------------------------------------------------------------------
        | Modules path
        |--------------------------------------------------------------------------
        |
        | This path used for save the generated module. This path also will be added
        | automatically to list of scanned folders.
        |
        */

        'modules' => base_path('Modules'),
        /*
        |--------------------------------------------------------------------------
        | Modules assets path
        |--------------------------------------------------------------------------
        |
        | Here you may update the modules assets path.
        |
        */

        'assets' => public_path('modules'),
        /*
        |--------------------------------------------------------------------------
        | The migrations path
        |--------------------------------------------------------------------------
        |
        | Where you run 'module:publish-migration' command, where do you publish the
        | the migration files?
        |
        */

        'migration' => base_path('database/migrations'),
        /*
        |--------------------------------------------------------------------------
        | Generator path
        |--------------------------------------------------------------------------
        | Customise the paths where the folders will be generated.
        | Set the generate key to false to not generate that folder
        */
        'generator' => [
            'test'                  => ['path' => 'Tests/Unit'              , 'generate' => false],
            'test-feature'          => ['path' => 'Tests/Feature'           , 'generate' => false],
            'command'               => ['path' => 'Console'                 , 'generate' => false],
            'seeder'                => ['path' => 'Database/Seeders'        , 'generate' => false],
            'factory'               => ['path' => 'Database/factories'      , 'generate' => false],
            'event'                 => ['path' => 'Events'                  , 'generate' => false],
            'listener'              => ['path' => 'Listeners'               , 'generate' => false],
            'policies'              => ['path' => 'Policies'                , 'generate' => false],
            'rules'                 => ['path' => 'Rules'                   , 'generate' => false],
            'jobs'                  => ['path' => 'Jobs'                    , 'generate' => false],
            'emails'                => ['path' => 'Emails'                  , 'generate' => false],
            'notifications'         => ['path' => 'Notifications'           , 'generate' => false],
            'config'                => ['path' => 'Config'                  , 'generate' => true],
            'model'                 => ['path' => 'Entities'                , 'generate' => true],
            'migration'             => ['path' => 'Database/Migrations'     , 'generate' => true],
            'filter'                => ['path' => 'Http/Middleware'         , 'generate' => true],
            'lang'                  => ['path' => 'Resources/lang'          , 'generate' => true],
            'provider'              => ['path' => 'Providers'               , 'generate' => true],
            'repository'            => ['path' => 'Repositories'            , 'generate' => true],
            'repository-frontend'   => ['path' => 'Repositories/Frontend'   , 'generate' => true],
            'repository-dashboard'  => ['path' => 'Repositories/Dashboard'  , 'generate' => true],
            'repository-api'        => ['path' => 'Repositories/Api'        , 'generate' => true],

            'resource'            => ['path' => 'Transformers'              , 'generate' => true],
            'resource-frontend'   => ['path' => 'Transformers/Frontend'     , 'generate' => true],
            'resource-dashboard'  => ['path' => 'Transformers/Dashboard'    , 'generate' => true],
            'resource-api'        => ['path' => 'Transformers/Api'          , 'generate' => true],

            'routes'              => ['path' => 'Routes'                    , 'generate' => true],
            'routes-frontend'     => ['path' => 'Routes/frontend'           , 'generate' => true],
            'routes-dashboard'    => ['path' => 'Routes/dashboard'          , 'generate' => true],
            'routes-api'          => ['path' => 'Routes/api'                , 'generate' => true],

            'request'             => ['path' => 'Http/Requests'             , 'generate' => true],
            'request-frontend'    => ['path' => 'Http/Requests/Frontend'    , 'generate' => true],
            'request-dashboard'   => ['path' => 'Http/Requests/Dashboard'   , 'generate' => true],
            'request-api'         => ['path' => 'Http/Requests/Api'         , 'generate' => true],

            'controller'          => ['path' => 'Http/Controllers'          , 'generate' => true],
            'controller-frontend' => ['path' => 'Http/Controllers/Frontend' , 'generate' => true],
            'controller-dashboard'=> ['path' => 'Http/Controllers/Dashboard', 'generate' => true],
            'controller-api'      => ['path' => 'Http/Controllers/Api','generate' => true],

            'views'               => ['path' => 'Resources/views'           , 'generate' => true],
            'views-frontend'      => ['path' => 'Resources/views/frontend'  , 'generate' => true],
            'views-dashboard'     => ['path' => 'Resources/views/dashboard' , 'generate' => true],

        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Package commands
    |--------------------------------------------------------------------------
    |
    | Here you can define which commands will be visible and used in your
    | application. If for example you don't use some of the commands provided
    | you can simply comment them out.
    |
    */
    'commands' => [
        CommandMakeCommand::class,
        ControllerMakeCommand::class,
        DisableCommand::class,
        DumpCommand::class,
        EnableCommand::class,
        EventMakeCommand::class,
        JobMakeCommand::class,
        ListenerMakeCommand::class,
        MailMakeCommand::class,
        MiddlewareMakeCommand::class,
        NotificationMakeCommand::class,
        ProviderMakeCommand::class,
        RouteProviderMakeCommand::class,
        InstallCommand::class,
        ListCommand::class,
        ModuleDeleteCommand::class,
        ModuleMakeCommand::class,
        FactoryMakeCommand::class,
        PolicyMakeCommand::class,
        RequestMakeCommand::class,
        RuleMakeCommand::class,
        MigrateCommand::class,
        MigrateRefreshCommand::class,
        MigrateResetCommand::class,
        MigrateRollbackCommand::class,
        MigrateStatusCommand::class,
        MigrationMakeCommand::class,
        ModelMakeCommand::class,
        PublishCommand::class,
        PublishConfigurationCommand::class,
        PublishMigrationCommand::class,
        PublishTranslationCommand::class,
        SeedCommand::class,
        SeedMakeCommand::class,
        SetupCommand::class,
        UnUseCommand::class,
        UpdateCommand::class,
        UseCommand::class,
        ResourceMakeCommand::class,
        TestMakeCommand::class,
        LaravelModulesV6Migrator::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Scan Path
    |--------------------------------------------------------------------------
    |
    | Here you define which folder will be scanned. By default will scan vendor
    | directory. This is useful if you host the package in packagist website.
    |
    */

    'scan' => [
        'enabled' => false,
        'paths' => [
            base_path('vendor/*/*'),
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Composer File Template
    |--------------------------------------------------------------------------
    |
    | Here is the config for composer.json file, generated by this package
    |
    */

    'composer' => [
        'vendor' => 'nwidart',
        'author' => [
            'name' => 'Nicolas Widart',
            'email' => 'n.widart@gmail.com',
        ],
    ],

    'composer-output' => false,

    /*
    |--------------------------------------------------------------------------
    | Caching
    |--------------------------------------------------------------------------
    |
    | Here is the config for setting up caching feature.
    |
    */
    'cache' => [
        'enabled' => false,
        'key' => 'laravel-modules',
        'lifetime' => 60,
    ],
    /*
    |--------------------------------------------------------------------------
    | Choose what laravel-modules will register as custom namespaces.
    | Setting one to false will require you to register that part
    | in your own Service Provider class.
    |--------------------------------------------------------------------------
    */
    'register' => [
        'translations' => true,
        /**
         * load files on boot or register method
         *
         * Note: boot not compatible with asgardcms
         *
         * @example boot|register
         */
        'files' => 'register',
    ],

    /*
    |--------------------------------------------------------------------------
    | Activators
    |--------------------------------------------------------------------------
    |
    | You can define new types of activators here, file, database etc. The only
    | required parameter is 'class'.
    | The file activator will store the activation status in storage/installed_modules
    */
    'activators' => [
        'file' => [
            'class' => FileActivator::class,
            'statuses-file' => base_path('modules_statuses.json'),
            'cache-key' => 'activator.installed',
            'cache-lifetime' => 604800,
        ],
    ],

    'activator' => 'file',
];
