<?php

namespace Dminustin\ApiFactory;

use Dminustin\ApiFactory\Classes\Config;
use Dminustin\ApiFactory\Classes\Generators\HttpActionGenerator;
use Dminustin\ApiFactory\Classes\Generators\HttpControllerGenerator;
use Dminustin\ApiFactory\Classes\Generators\RouterGenerator;
use Dminustin\ApiFactory\Classes\Generators\SwaggerGenerator;
use Dminustin\ApiFactory\Classes\Logger;
use Dminustin\ApiFactory\Classes\RouterConfig\EndPointCollection;

class LaravelApiFactory
{
    protected array $generators = [
        RouterGenerator::class => 'generateRoutes',
        HttpControllerGenerator::class => 'generateControllers',
        HttpActionGenerator::class => 'generateActions',
        SwaggerGenerator::class => 'generateSwaggerDoc',
    ];

    protected Config $config;
    protected Logger $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
        $this->setConfig(new Config(config('api-factory')));
    }

    /**
     * @param Config $config
     * @return static
     */
    public function setConfig(Config $config): static
    {
        $this->config = $config;
        return $this;
    }

    public function getGenerators(EndPointCollection $routes): array
    {
        $result = [];
        foreach ($this->generators as $generator => $flag) {
            if ($this->config->$flag === true) {
                $result[] = new $generator($this->config, $routes->getEndPoints(), $this->logger);
            }
        }
        return $result;
    }
}
