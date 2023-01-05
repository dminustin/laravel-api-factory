<?php

namespace Dminustin\ApiFactory\Classes;

/**
 * @property array $data
 * @property bool $result
 */
class ApiResponse extends BaseModel
{
    protected array $data;
    protected array $errors;
    protected bool $result = true;

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return static
     */
    public function setData(array $data): static
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return bool
     */
    public function isResult(): bool
    {
        return $this->result;
    }

    /**
     * @param bool $result
     * @return static
     */
    public function setResult(bool $result): static
    {
        $this->result = $result;
        return $this;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     * @return static
     */
    public function setErrors(array $errors): static
    {
        $this->errors = $errors;
        return $this;
    }

    /**
     * @param string $error
     * @return static
     */
    public function addError(string $error): static
    {
        if (empty($this->errors)) {
            $this->errors = [];
        }
        $this->errors[] = $error;
        return $this;
    }
}
