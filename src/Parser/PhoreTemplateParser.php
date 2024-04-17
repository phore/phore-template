<?php

namespace Phore\Template;

class PhoreTemplateParser
{

    public function __construct(
        /**
         * The template to parse as array of lines
         *
         * @var string[] $template
         */
        protected array $template,
        protected TemplateOptions|int $options = 0
    )
    {

    }


    protected array $filters = [];

    public function addFilter(TemplateFilter $filter)
    {

        $this->filters[] = $filter;
    }


    public function parse() : array
    {

        $stateMaschine = new TemplateStateMaschine();
        $contentBuffer = [];
        $input = $this->template;
        for ($i=0; $i<count($input); $i++) {
            $line = $input[$i];
            if (preg_match("/^{%(.*)%}$/", $line, $matches)) {
                $stateMaschine->injectTag($contentBuffer, trim($matches[1]), $i);
                $contentBuffer = [];
                continue;
            }
            $contentBuffer[$i] = $line;
        }

    }


}
