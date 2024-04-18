<?php

namespace Phore\Template\Pipe;

class NextFilter
{

    public function __construct(private \Closure $callback)
    {

    }


    public function filter($value) : string
    {
        return ($this->callback)($value);
    }

}
