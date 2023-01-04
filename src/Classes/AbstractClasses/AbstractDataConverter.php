<?php

namespace Dminustin\ApiFactory\Classes\AbstractClasses;

abstract class AbstractDataConverter
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    abstract public function convert(): mixed;
}
