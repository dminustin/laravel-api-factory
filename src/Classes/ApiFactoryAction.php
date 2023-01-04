<?php

namespace Dminustin\ApiFactory\Classes;

use Illuminate\Http\Request;

class ApiFactoryAction
{
    protected array $validationRules = [];
    protected array $data = [];

    public function checkAndFillRequestData(Request $request)
    {
        $request->validate($this->validationRules);
        $this->data = $request->safe()->only($this->validationRules);
    }
}
