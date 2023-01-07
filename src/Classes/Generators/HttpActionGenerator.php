<?php

namespace Dminustin\ApiFactory\Classes\Generators;

use Dminustin\ApiFactory\Classes\AbstractClasses\AbstractGenerator;
use Dminustin\ApiFactory\Classes\ClassAttributes;
use Dminustin\ApiFactory\Classes\RouterConfig\EndPoint;

class HttpActionGenerator extends AbstractGenerator
{
    protected string $name = 'Action Generator';

    protected function run()
    {
        $template = $this->loadTemplate('api_factory_action');

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

            $rules = ['['];
            foreach ($route->params as $key => $value) {
                $rules[] = '        \'' . $key . '\'=>\'' .
                    $value
                    . '\',';
            }
            $rules[] = '    ]';

            $this->renderingMap = [
                'namespace' => $actionAttributes->getNameSpace(),
                'className' => $actionAttributes->getShortClassName(),
                'actionName' => $actionAttributes->getClassName(),
                'rules' => implode(PHP_EOL, $rules),
                'generator' => $this->info->getGeneratorTitle()
            ];

            $rendered = $this->render($template);
            $this->saveFile($actionAttributes->getFilePath(), $rendered, $this->config->overrideActions);
        }
    }
}
