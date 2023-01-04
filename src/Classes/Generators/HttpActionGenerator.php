<?php

namespace Dminustin\ApiFactory\Classes\Generators;

use Dminustin\ApiFactory\Classes\AbstractClasses\AbstractGenerator;
use Dminustin\ApiFactory\Classes\ClassAttributes;
use Dminustin\ApiFactory\Classes\RouterConfig\EndPoint;

class HttpActionGenerator extends AbstractGenerator
{
    public function generate()
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

            if (!$this->config->overrideControllers && file_exists($actionAttributes->getFilePath())) {
                $this->log->warning('Action exists: ' . json_encode([
                        'Path:' => $route->path,
                        'Filename:' => $actionAttributes->getFilePath(),
                        'ClassName:' => $actionAttributes->getClassName(),
                        'ShortName:' => $actionAttributes->getShortClassName(),
                    ]));
                continue;
            }

            $this->log->info('Generate Action ' . json_encode([
                    'Path:' => $route->path,
                    'Filename:' => $actionAttributes->getFilePath(),
                    'ClassName:' => $actionAttributes->getClassName(),
                    'ShortName:' => $actionAttributes->getShortClassName(),
                ]));

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
            ];

            $rendered = $this->render($template);
            $this->writeFile($rendered, $actionAttributes->getFilePath());
        }
    }
}
