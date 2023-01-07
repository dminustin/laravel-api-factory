<?php

namespace Dminustin\ApiFactory\Classes\DataConverters;

use Dminustin\ApiFactory\Classes\AbstractClasses\AbstractDataConverter;
use Illuminate\Http\Request;

class ArrayToRequestConverter extends AbstractDataConverter
{
    /**
     * @return Request
     */
    public function convert(): mixed
    {
        $request = new \Illuminate\Http\Request();
        $request->replace($this->data);
        return $request;
    }
}
