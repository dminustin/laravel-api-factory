<?php

namespace Dminustin\ApiFactory\Classes\AbstractClasses;

use Dminustin\ApiFactory\Classes\Config;
use Dminustin\ApiFactory\Classes\GeneratorInfo;
use Dminustin\ApiFactory\Classes\Logger;
use Dminustin\ApiFactory\Classes\RouterConfig\EndPoint;

abstract class AbstractGenerator
{
    protected Config $config;
    protected Logger $log;
    protected array $renderingMap = [];
    protected string $name = '';
    protected GeneratorInfo $info;

    /**
     * @var array<EndPoint> $routes
     */
    protected $routes;

    public function __construct(Config $config, array $routes, Logger $log, GeneratorInfo $generatorInfo)
    {
        $this->config = $config;
        $this->routes = $routes;
        $this->log = $log;
        $this->info = $generatorInfo;
    }

    public function generate()
    {
        $this->log->header($this->name);
        $this->run();
        $this->log->footer($this->name);
    }

    abstract protected function run();

    protected function saveFile($outFileName, $file, $override = false): bool
    {
        if (!is_dir(dirname($outFileName))) {
            mkdir(dirname($outFileName), 0777, true);
        }
        if (file_exists($outFileName) && !$override) {
            $this->log->warning('File already exists: ' . $outFileName);
            return false;
        }
        if (false === file_put_contents($outFileName, $file)) {
            $this->log->warning('Cannot save file: ' . $outFileName);
            return false;
        } else {
            $this->log->info('Saved successful: ' . $outFileName);
        }
        return true;
    }

    protected function loadTemplate(string $templateName): string
    {
        return file_get_contents(base_path('stubs/' . $templateName));
    }

    protected function render(string $template): string
    {
        foreach ($this->renderingMap as $key => $value) {
            $template = str_replace('%' . $key . '%', $value, $template);
        }
        return trim($template);
    }
}
