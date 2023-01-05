<?php

namespace Dminustin\ApiFactory\Classes;

/**
 * @property string $name
 * @property string $version
 */
class GeneratorInfo extends BaseModel
{
    protected string $name = 'Laravel API Factory';
    protected string $version;
}
