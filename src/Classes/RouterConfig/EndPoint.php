<?php

namespace Dminustin\ApiFactory\Classes\RouterConfig;

use Dminustin\ApiFactory\Classes\BaseModel;

/**
 * Class RouteConfig
 * @property string $method
 * @property string $path
 * @property string $description
 * @property array $produces
 * @property array $responses
 * @property array $middlewares
 * @property array $params
 * @property array $headers
 * @property array $tags
 */
class EndPoint extends BaseModel
{
    protected string $method;
    protected string $path;
    protected string $description = '';
    protected array $responses = [
        200 => [
            'schema' => ['$ref' => '#/definitions/baseResponse']
        ]
    ];
    protected array $tags = [];
    protected array $headers = [];
    protected array $produces = ['application/json'];
    protected array $middlewares = [];
    protected array $params = [];
}
