<?php

namespace Phore\Template\Pipe;

use Phore\Template\TemplateFilter;

class FilterGroup
{

    /**
     * @var TemplateFilter[]
     */
    private $filterPipeline = [];

    public function addFilter($filter)
    {
        $this->filterPipeline[] = $filter;
    }

    public function perform($value, int $depth = 0) : string|null
    {
        if ($depth > count($this->filterPipeline) - 1)
            return $value;
        return $this->filterPipeline[$depth]->filter($value, new NextFilter(fn ($value) => $this->perform($value, $depth+1)));
    }

}
