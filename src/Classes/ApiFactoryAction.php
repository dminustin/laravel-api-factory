<?php

namespace Dminustin\ApiFactory\Classes;

use Illuminate\Http\Request;

abstract class ApiFactoryAction
{
    protected array $validationRules = [];
    protected array $data = [];
    protected ApiResponse $response;

    public function run(Request $request): ApiResponse
    {
        $this->response = new ApiResponse();
        try {
            $this->checkAndFillRequestData($request);
        } catch (\Exception $e) {
            return
                $this->response
                    ->setResult(false)
                    ->setErrors([$e->getMessage()]);
        }
        return $this->handle();
    }

    protected function checkAndFillRequestData(Request $request)
    {
        $this->data = $request->validate($this->validationRules);
    }

    abstract protected function handle(): ApiResponse;

    /**
     * @return array
     */
    public function getValidationRules(): array
    {
        return $this->validationRules;
    }
}
