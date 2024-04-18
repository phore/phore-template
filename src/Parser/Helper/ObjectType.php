<?php

namespace Phore\Template\Parser\Helper;

class ObjectType
{

    public function __construct(
        public readonly ObjectTypeTypeEnum  $type,
        public readonly mixed $value
    )
    {

    }

}
