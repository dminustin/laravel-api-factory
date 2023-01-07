<?php

namespace Dminustin\ApiFactory;

use Dminustin\ApiFactory\Classes\AbstractClasses\AbstractGenerator;
use Dminustin\ApiFactory\Classes\Config;
use Dminustin\ApiFactory\Classes\GeneratorInfo;
use Dminustin\ApiFactory\Classes\Generators\HttpActionGenerator;
use Dminustin\ApiFactory\Classes\Generators\HttpControllerGenerator;
use Dminustin\ApiFactory\Classes\Generators\PostmanCollectionGenerator;
use Dminustin\ApiFactory\Classes\Generators\RouterGenerator;
use Dminustin\ApiFactory\Classes\Generators\SwaggerGenerator;
use Dminustin\ApiFactory\Classes\Generators\TestsGenerator;
use Dminustin\ApiFactory\Classes\Logger;
use Dminustin\ApiFactory\Classes\RouterConfig\EndPoint;
use Dminustin\ApiFactory\Classes\RouterConfig\EndPointCollection;

class LaravelApiFactory
{
    /**
     * @var array|string[]
     */
    protected array $generators = [
        RouterGenerator::class => 'generateTests',
        TestsGenerator::class => 'generateRoutes',
        HttpControllerGenerator::class => 'generateControllers',
        HttpActionGenerator::class => 'generateActions',
        SwaggerGenerator::class => 'generateSwaggerDoc',
        PostmanCollectionGenerator::class => 'generatePostmanCollection',
    ];

    protected Config $config;
    protected Logger $logger;
    protected GeneratorInfo $info;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
        $this->setConfig(new Config(config('api-factory')));
        $composerFile = json_decode(file_get_contents(__DIR__ . '/../composer.json'), false);
        $this->info = new GeneratorInfo(
            [
                'version' => $composerFile->version,
            ]
        );
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

    /**
     * @param EndPointCollection $routes
     * @return array<AbstractGenerator>
     */
    public function getGenerators(EndPointCollection $routes): array
    {
        $result = [];
        foreach ($this->generators as $generator => $flag) {
            if ($this->config->$flag === true) {
                $result[] = new $generator(
                    $this->config,
                    $routes->getEndPoints(),
                    $this->logger,
                    $this->info
                );
            }
        }
        return $result;
    }
}
