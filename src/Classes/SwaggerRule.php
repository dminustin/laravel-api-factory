<?php

namespace Dminustin\ApiFactory\Classes;

/**
 * Class Swagger Rule
 * @property string $name;
 * @property string $in = 'query';
 * @property string $description;
 * @property bool $required = false;
 * @property string $type = 'integer';
 * @property string $format;
 */
class SwaggerRule extends BaseModel
{
    protected string $name;
    protected string $in = 'query';
    protected string $description;
    protected bool $required = false;
    protected string $type;
    protected string $format;

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
