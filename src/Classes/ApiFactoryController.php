<?php

namespace Dminustin\ApiFactory\Classes;

use App\Http\Controllers\Controller;
use Dminustin\ApiFactory\Exceptions\ClassNotFoundException;
use Illuminate\Http\Request;

class ApiFactoryController extends Controller
{
    protected string $actionName;

    public function handle(Request $request)
    {
        $action = $this->getAction($request);
        return response()->json($action->run($request)->toArray());
    }

    protected function getAction(Request $request): ApiFactoryAction
    {
        if (!class_exists($this->actionName)) {
            throw new ClassNotFoundException();
        }
        return new $this->actionName($request);
    }
}
