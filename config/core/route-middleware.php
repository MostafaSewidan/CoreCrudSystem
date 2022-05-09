<?php

return [
    'dashboard' => [
        'auth' => [
            'web',
            'auth:admin',
            'localizationRedirect',
            'localeSessionRedirect',
            'localeViewPath',
            'localize',
            'dashboard.auth',
            'check.permission',
            'last.login',
        ],
        'guest' => [
            'web',
            'localizationRedirect',
            'localeSessionRedirect',
            'localeViewPath',
            'localize',
            'guest:admin',
        ]
    ],

    'frontend' => [
        'auth' => [
            'web',
            'localizationRedirect',
            'localeSessionRedirect',
            'localeViewPath',
        ],
        'guest' => [
            'web',
            'localizationRedirect',
            'localeSessionRedirect',
            'localeViewPath',
            'localize',
        ]
    ],

    'api' => [
        'auth' => [
            'api',
            'auth:api-client',
            'api.switch.languages',
        ],
        'guest' => [
            'api',
            'api.switch.languages',
        ]
    ],
];
