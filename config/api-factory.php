<?php

return [
    'generateTests' => true,
    'generateRoutes' => true,
    'generateControllers' => true,
    'generateActions' => true,
    'generatePostmanCollection' => true,
    'generateSwaggerDoc' => true,
    'overrideControllers' => false,
    'overrideActions' => false,
    'overrideTests' => false,
    'routesFile' => 'app/routes/example.yaml',

    'outRouteFileName' => 'routes/web.php',

    'uriPrefix' => '/api/v1',

    'generatedControllerPathPrefix' => 'app/Http/ApiFactory/Controllers',
    'generatedActionPathPrefix' => 'app/Http/ApiFactory/Actions',

    'generatedControllerNSPrefix' => 'App/Http/ApiFactory/Controllers',
    'generatedActionNSPrefix' => 'App/Http/ApiFactory/Actions',

    'generatedControllerNSSuffix' => 'Controller',
    'generatedActionNSSuffix' => 'Action',


    'middlewares' => [
        'auth' => ['auth', 'registered'],
        'guest' => ['guest'],
        'admin' => ['roleAdmin']
    ],

    //Swagger response definitions
    'definitions' => [
        'baseResponse' => [
            'type' => 'object',
            'required' => [
                'result',
                'data'
            ],
            'properties' => [
                'result' => [
                    'type' => 'boolean',
                ],
                'data' => [
                    'type' => 'object'
                ]

            ]
        ]
    ]
];