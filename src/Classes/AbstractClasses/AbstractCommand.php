<?php

namespace Dminustin\ApiFactory\Classes\AbstractClasses;

abstract class AbstractCommand
{
    protected mixed $params;

    abstract public function getCommandName(): string;

    /**
     * @return mixed
     */
    public function getParams(): mixed
    {
        return $this->params ?: '';
    }

    /**
     * @param mixed $params
     * @return self
     */
    public function setParams(mixed $params): self
    {
        $this->params = $params;

        return $this;
    }

    public function toArray(): array
    {
        return [$this->getCommandName() => $this->getParams()];
    }

}
