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
    protected Config $config;
    protected array $middlewaresPrompt = [];
    protected array $middleWares = [];
    protected EndPointCollection $routes;

    public function __construct()
    {
        parent::__construct();
        $this->config = new Config(config('api-factory'));

        $this->routes = new EndPointCollection(
            Yaml::parseFile(
                base_path(config('api-factory')['routesFile'])
            )
        );
        $this->fillMiddlewares();
    }

    /**
     * @throws Exception
     */
    public function handle(): void
    {
        $newRoute = $this->askSettings();

        /** @var EndPoint $route */
        foreach ($this->routes->getEndPoints() as $route) {
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

        $this->routes->addEndPoint('', $newRoute);

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
            file_put_contents(base_path($this->config->routesFile), Yaml::dump($this->routes->toArray()));
            Artisan::call('api:factory');
        }
    }

    protected function askSettings(): array
    {
        $newRoute = [];

        while (empty($newRoute['path'])) {
            $newRoute['path'] = $this->ask('URI address without uriPrefix, for example: auth/login', '');
        }
        while (empty($newRoute['method'])) {
            $newRoute['method'] = $this->choice(
                'Request method',
                ['post', 'get', 'put', 'delete', 'patch', 'any'],
                'post'
            );
        }

        $newRoute['description'] = $this->ask('Description of this route', '');

        while (empty($chosenMiddlewares)) {
            $chosenMiddlewares = $this->choice('Middlewares', $this->middlewaresPrompt, 'empty');
        }

        $chosenMiddlewaresIndex = array_search($chosenMiddlewares, $this->middlewaresPrompt);
        $keys = array_keys($this->middleWares);
        $newRoute['middlewares'] = $this->middleWares[$keys[$chosenMiddlewaresIndex]];

        $newRoute['params'] = [];

        while (true) {
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

        return $newRoute;
    }

    protected function fillMiddlewares(): void
    {
        $this->middlewaresPrompt = ['empty'];
        $this->middleWares = ['empty' => []];

        foreach ($this->config->middlewares as $key => $vals) {
            $this->middlewaresPrompt[] = $key . ': ' . implode(', ', $vals);
            $this->middleWares[$key] = $vals;
        }
    }

    protected function stopApp(string $message): void
    {
        $this->warn($message);
        exit(0);
    }
}
