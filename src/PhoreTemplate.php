<?php

namespace Phore\Template;




class PhoreTemplate
{
    
    public function __construct(
        protected ?string $templateString = null,
        protected ?string $templateFile = null,
        public array $data = [],
        TemplateOptions $options = null
    )
    {
    }

    public function getOriginalContent() : string
    {
        if ($this->templateString !== null)
            return $this->templateString;
        return phore_file($this->templateFile)->get_contents();
    }



    public function triggerFormatError(string $msg)
    {

        throw new \InvalidArgumentException($msg);
    }


    public function parse() {

    }








}
