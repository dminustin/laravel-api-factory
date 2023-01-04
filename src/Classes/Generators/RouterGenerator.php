<?php

namespace Dminustin\ApiFactory\Classes\Generators;

use Dminustin\ApiFactory\Classes\AbstractClasses\AbstractGenerator;
use Dminustin\ApiFactory\Classes\ClassAttributes;
use Dminustin\ApiFactory\Classes\RouterConfig\EndPoint;
use Dminustin\ApiFactory\Traits\HasClass;

class RouterGenerator extends AbstractGenerator
{
    protected const DIVIDER = PHP_EOL . '//GENERATED-BY-Laravel-Api-Factory' . PHP_EOL;

    /**
     * @todo todo group routes by middlewares
     */
    public function generate()
    {
        $template = $this->loadTemplate('api_factory_router');

        $result = [];
        /**
         * @var EndPoint $route
         */
        foreach ($this->routes as $route) {
            $classAttributes = new ClassAttributes(
                $route->path,
                $this->config->generatedControllerPathPrefix,
                $this->config->generatedControllerNSPrefix,
                $this->config->generatedControllerNSSuffix,
            );
            $this->renderingMap = [
                'namespace' => $classAttributes->getNameSpace(),
                'className' => $classAttributes->getClassName(),
                'method' => $route->method,
                'path' => $route->path,
            ];
            $result[] = $this->render($template);
        }

        $fName = base_path($this->config->outRouteFileName);
        $file = file_get_contents($fName);
        $file = explode(static::DIVIDER, $file, 2);
        if (count($file) === 1) {
            $file[] = '';
        }
        $file[0] = trim($file[0]);
        $file[1] = implode(PHP_EOL, $result);
        file_put_contents($fName, implode(static::DIVIDER, $file));
    }
}
