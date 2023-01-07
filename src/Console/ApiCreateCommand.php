<?php

namespace Dminustin\ApiFactory\Console;

use Dminustin\ApiFactory\Classes\Config;
use Dminustin\ApiFactory\Classes\RouterConfig\EndPoint;
use Dminustin\ApiFactory\Classes\RouterConfig\EndPointCollection;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Yaml\Yaml;

use function Orchestra\Testbench\artisan;

class ApiCreateCommand extends Command
{
    protected $signature = 'api:create';

    /**
     * @throws Exception
     */
    public function handle(): void
    {
        $routes = new EndPointCollection(
            Yaml::parseFile(
                base_path(config('api-factory')['routesFile'])
            )
        );

        $newRoute = [];

        $config = new Config(config('api-factory'));

        $mw = ['empty'];
        $middlewares = ['empty' => []];
        foreach ($config->middlewares as $key => $vals) {
            $mw[] = $key . ': ' . implode(', ', $vals);
            $middlewares[$key] = $vals;
        }

        while (empty($newRoute['path'])) {
            $newRoute['path'] = $this->ask('URI address without uriPrefix, for example: auth/login', '');
        }
        while (empty($newRoute['method'])) {
            $newRoute['method'] = $this->choice('Request method', ['post', 'get', 'put', 'delete', 'patch', 'any'], 'post');
        }

        $newRoute['description'] = $this->ask('Description of thiss route', '');

        /** @var EndPoint $route */
        foreach ($routes->getEndPoints() as $route) {
            if (
                $route->path === $newRoute['path'] &&
                $route->method === $newRoute['method']
            ) {
                $this->stopApp(sprintf(
                    'Route %s : %s already exists',
                    $newRoute['method'],
                    $newRoute['path']
                ));
            }
        }

        while (empty($newRoute['middlewares'])) {
            $newRoute['middlewares'] = $this->choice('Middlewares', $mw, 'empty');
        }

        $newRoute['middlewares'] = $middlewares[$newRoute['middlewares']];

        $newRoute['params'] = [];
        for (; ;) {
            $newParam = $this->ask('Param name', '');
            if (empty($newParam)) {
                $stop = $this->choice('Stop asking params', ['yes', 'no'], 'yes');
                if ($stop === 'yes') {
                    break;
                }
                continue;
            }
            $newParamAttribute = $this->ask('Param attributes (required, nullable etc)', '');
            $newRoute['params'][$newParam] = $newParamAttribute;
        }

        $routes->addEndPoint('', $newRoute);

        $ep = sprintf(
            "URI: %s,\nMethod: %s,\nDescription: %s,\nMiddleware: %s,\nParams: %s",
            $newRoute['path'],
            $newRoute['method'],
            $newRoute['description'],
            var_export($newRoute['middlewares'], true),
            var_export($newRoute['params'], true)
        );

        $confirm = $this->choice('Confirm to create endpoint: ' . $ep, ['yes', 'no']);
        if ($confirm === 'yes') {
            file_put_contents(base_path($config->routesFile), Yaml::dump($routes->toArray()));
            Artisan::call('api:factory');
        }
    }

    protected function stopApp(string $message): void
    {
        $this->warn($message);
        exit(0);
    }
}
