<?php

namespace Dminustin\ApiFactory\Classes\DataConverters;

use Dminustin\ApiFactory\Classes\AbstractClasses\AbstractDataConverter;

class SwaggerParamsConverter extends AbstractDataConverter
{
    protected string $in;

    public function convert(): mixed
    {
        $result = [];
        foreach ($this->data as $name => $rules) {
            $result[] =
                array_merge(
                    ['name' => $name],
                    (new RuleConverter($rules))->convert()
                        ->setIn($this->in)
                        ->toArray()
                );
        }
        return $result;
    }

    /**
     * @param string $in
     * @return static
     */
    public function setIn(string $in): static
    {
        $this->in = $in;
        return $this;
    }
}
