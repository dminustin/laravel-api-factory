<?php

namespace Dminustin\ApiFactory;

use Dminustin\ApiFactory\Classes\Logger;
use Dminustin\ApiFactory\Console\ApiCreateCommand;
use Dminustin\ApiFactory\Console\ApiFactoryCommand;
use Illuminate\Support\ServiceProvider;

class LaravelApiFactoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/api-factory.php' =>
                    config_path('api-factory.php'),
                __DIR__ . '/../routes/example.yaml' =>
                    base_path('app/routes/example.yaml'),
                __DIR__ . '/../stubs/api_factory_controller' =>
                    base_path('stubs/api_factory_controller'),
                __DIR__ . '/../stubs/api_factory_action' =>
                    base_path('stubs/api_factory_action'),
                __DIR__ . '/../stubs/api_factory_router' =>
                    base_path('stubs/api_factory_router')
            ], 'api-factory');

            $this->commands([
                ApiFactoryCommand::class,
                ApiCreateCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/api-factory.php', 'api-factory');

        $this->app->singleton('api-factory', function () {
            return new LaravelApiFactory(new Logger());
        });
    }
}
