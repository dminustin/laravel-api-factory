<?php

namespace Dminustin\ApiFactory\Classes;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Dminustin\ApiFactory\Classes\DataConverters\ArrayToRequestConverter;
use Dminustin\ApiFactory\Exceptions\ClassNotFoundException;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Contracts\Console\Kernel;
use Tests\CreatesApplication;

class ApiFactoryTestCase extends BaseTestCase
{
    use DatabaseMigrations;

    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';
        $app->make(Kernel::class)->bootstrap();
        return $app;
    }

    /**
     * @throws ClassNotFoundException
     */
    protected function getActionResponse(string $className, array $data = []): ApiResponse
    {
        if (!class_exists($className)) {
            throw new ClassNotFoundException('Class ' . $className . ' not found');
        }
        return (new $className())->run(
            (new ArrayToRequestConverter($data))->convert()
        );
    }
}
