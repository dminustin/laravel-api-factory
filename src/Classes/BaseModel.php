<?php

namespace Dminustin\ApiFactory\Classes;

use Exception;

class BaseModel
{
    public function __construct(array $config = [])
    {
        foreach ($config as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * @throws Exception
     */
    public function __get($key)
    {
        return $this->checkProperty($key)->$key;
    }

    public function __set($key, $value)
    {
        $this->checkProperty($key)->$key = $value;
    }

    /**
     * @throws Exception
     */
    protected function checkProperty($key)
    {
        if (!property_exists($this, $key)) {
            throw new Exception('Unable to get property ' . $key);
        }
        return $this;
    }

    public function toArray(): array
    {
        $result = [];
        foreach (get_object_vars($this) as $key => $val) {
            $result[$key] = $val;
        }
        return $result;
    }
}
