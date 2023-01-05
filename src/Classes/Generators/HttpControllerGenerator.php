<?php

namespace Dminustin\ApiFactory\Classes\Generators;

use Dminustin\ApiFactory\Classes\AbstractClasses\AbstractGenerator;
use Dminustin\ApiFactory\Classes\ClassAttributes;
use Dminustin\ApiFactory\Classes\RouterConfig\EndPoint;

class HttpControllerGenerator extends AbstractGenerator
{
    protected string $name = 'Controller generator';

    protected function run()
    {
        $template = $this->loadTemplate('api_factory_controller');

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
            $actionAttributes = new ClassAttributes(
                $route->path,
                $this->config->generatedActionPathPrefix,
                $this->config->generatedActionNSPrefix,
                $this->config->generatedActionNSSuffix,
            );

            $this->renderingMap = [
                'namespace' => $classAttributes->getNameSpace(),
                'className' => $classAttributes->getShortClassName(),
                'actionName' => $actionAttributes->getClassName(),
                'generator' => $this->info->name . ' v.' . $this->info->version
            ];

            $rendered = $this->render($template);
            $this->saveFile($classAttributes->getFilePath(), $rendered, $this->config->overrideControllers);
        }
    }
}
