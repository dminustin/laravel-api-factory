<?php

namespace Dminustin\ApiFactory\Classes\Generators;

use Dminustin\ApiFactory\Classes\AbstractClasses\AbstractGenerator;
use Dminustin\ApiFactory\Classes\ClassAttributes;
use Dminustin\ApiFactory\Classes\RouterConfig\EndPoint;

class TestsGenerator extends AbstractGenerator
{
    protected string $name = 'Tests generator';

    protected function run()
    {
        $template = $this->loadTemplate('api_factory_test');

        /**
         * @var EndPoint $route
         */
        foreach ($this->routes as $route) {
            $actionAttributes = new ClassAttributes(
                $route->path,
                $this->config->generatedActionPathPrefix,
                $this->config->generatedActionNSPrefix,
                $this->config->generatedActionNSSuffix,
            );
            $testAttributes = new ClassAttributes(
                $route->path,
                'tests/Unit/ApiFactory/',
                'Tests\\Unit\\ApiFactory',
                'ActionTest',
            );

            $this->renderingMap = [
                'className' => $testAttributes->getShortClassName(),
                'namespace' => $testAttributes->getNameSpace(),
                'actionNamespace' => $actionAttributes->getNameSpace(),
                'actionName' => $actionAttributes->getShortClassName(),
                'generator' => $this->info->getGeneratorTitle()
            ];

            $rendered = $this->render($template);
            $this->saveFile($testAttributes->getFilePath(), $rendered, $this->config->overrideTests);
        }
    }
}
