<?php

namespace Dminustin\ApiFactory\Classes\DataConverters;

use Dminustin\ApiFactory\Classes\AbstractClasses\AbstractDataConverter;
use Dminustin\ApiFactory\Classes\SwaggerRule;

class RuleConverter extends AbstractDataConverter
{
    protected $typesMap = [
        'boolean' => ['type' => 'boolean'],
        'bool' => ['type' => 'boolean'],
        'file' => ['type' => 'string', 'format' => 'binary'],
        'string' => ['type' => 'string'],
        'email' => ['type' => 'string'],
        'integer' => ['type' => 'integer', 'format' => 'int64'],
    ];

    public function __construct($data)
    {
        $this->data = explode('|', $data);
    }

    public function convert(): SwaggerRule
    {
        $result = new SwaggerRule([]);
        $result->required = (in_array('required', $this->data));
        foreach ($this->typesMap as $type => $attributes) {
            if (in_array($type, $this->data)) {
                $result->type = $attributes['type'];
                if (isset($attributes['format'])) {
                    $result->format = $attributes['format'];
                }
            }
        }
        return $result;
    }
}
