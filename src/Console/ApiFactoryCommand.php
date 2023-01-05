<?php

namespace Dminustin\ApiFactory\Console;

use Dminustin\ApiFactory\Classes\AbstractClasses\AbstractGenerator;
use Dminustin\ApiFactory\Classes\RouterConfig\EndPointCollection;
use Dminustin\ApiFactory\LaravelApiFactory;
use Illuminate\Console\Command;
use Symfony\Component\Yaml\Yaml;

class ApiFactoryCommand extends Command
{
    protected $signature = 'api:factory';

    protected LaravelApiFactory $apiFactory;

    public function __construct(LaravelApiFactory $apiFactory)
    {
        parent::__construct();
        $this->apiFactory = $apiFactory;
    }


    public function handle(): void
    {
        $routes = new EndPointCollection(
            Yaml::parseFile(
                base_path(config('api-factory')['routesFile'])
            )
        );

        /**@var AbstractGenerator $generator */
        foreach ($this->apiFactory->getGenerators($routes) as $generator) {
            $generator->generate();
        }
    }
}
