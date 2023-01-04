<?php

namespace Dminustin\ApiFactory\Classes\AbstractClasses;

use Dminustin\ApiFactory\Classes\Config;
use Dminustin\ApiFactory\Classes\Logger;

abstract class AbstractGenerator
{
    protected Config $config;
    protected Logger $log;
    protected array $renderingMap = [];

    /**
     * @var []EndPoint $routes
     */
    protected $routes;

    public function __construct(Config $config, array $routes, Logger $log)
    {
        $this->config = $config;
        $this->routes = $routes;
        $this->log = $log;
    }

    abstract public function generate();

    protected function loadTemplate(string $templateName): string
    {
        return file_get_contents(base_path('stubs/' . $templateName));
    }

    protected function writeFile(string $rendered, string $outName)
    {
        $dir = dirname($outName);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        file_put_contents($outName, $rendered);
    }

    protected function render(string $template): string
    {
        foreach ($this->renderingMap as $key => $value) {
            $template = str_replace('%' . $key . '%', $value, $template);
        }
        return $template;
    }
}
