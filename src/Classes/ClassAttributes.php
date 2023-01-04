<?php

namespace Dminustin\ApiFactory\Classes;

class ClassAttributes
{
    protected string $nameSpace;
    protected string $className;
    protected string $filePath;
    protected string $uri;

    protected string $pathPrefix;
    protected string $nsPrefix;
    protected string $nsSuffix;

    public function __construct(
        string $uri,
        string $pathPrefix,
        string $nsPrefix,
        string $nsSuffix
    ) {
        $this->uri = $uri;
        $this->pathPrefix = $pathPrefix;
        $this->nsPrefix = $nsPrefix;
        $this->nsSuffix = $nsSuffix;

        $this->calcNameSpace();
        $this->calcClassName();
        $this->calcFilePath();
    }

    protected function calcNameSpace()
    {
        $tmp = explode('/', $this->formatName());
        array_pop($tmp);
        $this->nameSpace = implode('\\', $tmp);
    }

    protected function formatName()
    {
        $result = sprintf(
            '%s/%s%s',
            (!empty($this->nsPrefix)) ? $this->nsPrefix . '/' : '',
            ucwords($this->uri, '/'),
            (!empty($this->nsSuffix)) ? $this->nsSuffix : '',
        );
        return preg_replace('#[/]+#', '/', $result);
    }

    protected function calcClassName()
    {
        $this->className = str_replace('/', '\\', $this->formatName());
    }

    protected function calcFilePath()
    {
        $result = sprintf(
            '%s/%s%s',
            (!empty($this->pathPrefix)) ? $this->pathPrefix . '/' : '',
            ucwords($this->uri, '/'),
            (!empty($this->nsSuffix)) ? $this->nsSuffix : '',
        );
        $this->filePath = base_path(preg_replace('#[/]+#', '/', $result) . '.php');
    }

    /**
     * @return string
     */
    public function getNameSpace(): string
    {
        return $this->nameSpace;
    }

    /**
     * @return string
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * @return string
     */
    public function getShortClassName(): string
    {
        return last(explode('\\', $this->className));
    }

    /**
     * @return string
     */
    public function getFilePath(): string
    {
        return $this->filePath;
    }
}
