<?php

namespace Dminustin\ApiFactory\Classes\RouterConfig;

class EndPointCollection
{
    protected $endPoints = [];

    public function __construct($config)
    {
        foreach ($config as $prefix => $endPoints) {
            foreach ($endPoints as $endPoint) {
                $this->addEndPoint($prefix, $endPoint);
            }
        }
    }

    public function addEndPoint(string $prefix, array $endpoint): static
    {
        $point = new EndPoint($endpoint);
        $point->path = $prefix . $point->path;
        $this->endPoints[] = $point;
        return $this;
    }

    public function getEndPoints(): array
    {
        return $this->endPoints;
    }

    public function toArray()
    {
        $paths = [];
        foreach ($this->endPoints as $point) {
            $points[] = $point->toArray();
            $path = explode('/', $point->path);
            if (count($path) > 1) {
                array_pop($path);
                $key = implode('/', $path) . '/';
            } else {
                $key = $point->path;
            }
            $thisPoint = $point->toArray();
            $thisPoint['path'] = explode($key, $thisPoint['path'], 2);
            array_shift($thisPoint['path']);
            $thisPoint['path'] = implode('', $thisPoint['path']);
            if (!isset($paths[$key])) {
                $paths[$key] = [$thisPoint];
            } else {
                $paths[$key][] = $thisPoint;
            }
        }
        return $paths;
    }
}
