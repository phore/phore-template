<?php

namespace Phore\Template;


use Phore\Template\Pipe\NextFilter;

interface TemplateFilter
{


    /**
     * Return the name of the filter
     *
     * @return string
     */
    public function getName() : string;

    /**
     * Called once to set arguments
     *
     * @param array $arguemnts
     * @return mixed
     */
    public function setArguments(array $arguemnts);

    public function filter(string $data, NextFilter $next): string;

}
