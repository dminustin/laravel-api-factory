<?php

namespace Dminustin\ApiFactory\Classes;

/**
 * @property string $routesFile
 * @property string $outRouteFileName
 * @property bool $generateRoutes
 * @property bool $generateControllers
 * @property bool $generateActions
 * @property bool $generateSwaggerDoc
 * @property bool $overrideControllers
 * @property bool $overrideActions
 * @property string $uriPrefix
 * @property array $middlewares
 *
 * @property string $generatedControllerPathPrefix
 * @property string $generatedActionPathPrefix
 * @property string $generatedControllerNSPrefix
 * @property string $generatedActionNSPrefix
 * @property string $generatedControllerNSSuffix
 * @property string $generatedActionNSSuffix
 * @property array $definitions
 * @property array $components
 */
class Config extends BaseModel
{
    protected string $routesFile = 'app/routes/example.yaml';
    protected bool $generateRoutes = false;
    protected bool $generateControllers = false;
    protected bool $generateActions = false;
    protected bool $generateSwaggerDoc = false;
    protected bool $overrideControllers = false;
    protected bool $overrideActions = false;

    protected string $uriPrefix = '/api/v1/';
    protected array $middlewares = [];

    protected string $outRouteFileName = 'routes/web.php';

    protected string $generatedControllerPathPrefix = 'app/Http/Controllers/ApiFactory/Controllers';
    protected string $generatedActionPathPrefix = 'app/Actions/ApiFactory/Actions/';

    protected string $generatedControllerNSPrefix = 'App/Http/Controllers/ApiFactory/Controllers';
    protected string $generatedActionNSPrefix = 'App/Actions/ApiFactory/Actions';

    protected string $generatedControllerNSSuffix = 'Controller';
    protected string $generatedActionNSSuffix = 'Action';

    //swagger response definitions
    protected array $definitions = [];
    protected array $components = [];
}
