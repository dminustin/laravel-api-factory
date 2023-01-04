<?php

namespace Dminustin\ApiFactory\Classes\Generators;

use Dminustin\ApiFactory\Classes\AbstractClasses\AbstractGenerator;
use Dminustin\ApiFactory\Classes\ClassAttributes;
use Dminustin\ApiFactory\Classes\RouterConfig\EndPoint;

class HttpControllerGenerator extends AbstractGenerator
{
    public function generate()
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

            if (!$this->config->overrideControllers && file_exists($classAttributes->getFilePath())) {
                $this->log->warning('Class exists: ' . json_encode([
                        'Path:' => $route->path,
                        'Filename:' => $classAttributes->getFilePath(),
                        'ClassName:' => $classAttributes->getClassName(),
                        'ShortName:' => $classAttributes->getShortClassName(),
                    ]));
                continue;
            }

            $this->log->info('Generate Controller ' . json_encode([
                    'Path:' => $route->path,
                    'Filename:' => $classAttributes->getFilePath(),
                    'ClassName:' => $classAttributes->getClassName(),
                    'ShortName:' => $classAttributes->getShortClassName(),
                ]));

            $this->renderingMap = [
                'namespace' => $classAttributes->getNameSpace(),
                'className' => $classAttributes->getShortClassName(),
                'actionName' => $actionAttributes->getClassName(),
            ];

            $rendered = $this->render($template);
            $this->writeFile($rendered, $classAttributes->getFilePath());
        }
    }
}
