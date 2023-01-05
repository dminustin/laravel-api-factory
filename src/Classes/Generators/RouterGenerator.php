<?php

namespace Dminustin\ApiFactory\Classes\Generators;

use Dminustin\ApiFactory\Classes\AbstractClasses\AbstractGenerator;
use Dminustin\ApiFactory\Classes\ClassAttributes;
use Dminustin\ApiFactory\Classes\RouterConfig\EndPoint;
use Dminustin\ApiFactory\Traits\HasClass;

class RouterGenerator extends AbstractGenerator
{
    protected string $name = 'Router Generator';

    /**
     * @todo todo group routes by middlewares
     */
    protected function run()
    {
        $divider = PHP_EOL . '//GENERATED BY ' . $this->info->name . PHP_EOL;
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
                'path' => $this->config->uriPrefix . $route->path,
            ];
            $result[] = $this->render($template);
        }

        $fName = base_path($this->config->outRouteFileName);
        $file = file_get_contents($fName);
        $file = explode($divider, $file, 2);
        if (count($file) === 1) {
            $file[] = '';
        }
        $file[0] = trim($file[0]);
        $file[1] = implode(PHP_EOL, $result);
        $this->saveFile($fName, implode($divider, $file), true);
    }
}
