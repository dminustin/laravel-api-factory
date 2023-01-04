<?php

namespace Dminustin\ApiFactory\Classes;

use App\Http\Controllers\Controller;

class ApiFactoryController extends Controller
{
    protected string $actionName;

    protected function getAction(): ApiFactoryAction
    {
        return new $this->actionName();
    }
}
