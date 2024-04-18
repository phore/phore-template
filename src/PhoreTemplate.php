<?php

namespace Phore\Template;




class PhoreTemplate
{

    /**
     * @var TemplateFilter[]
     */
    private static $filters = [];

    public static function registerFilter(TemplateFilter $filter)
    {
        self::$filters[$filter->getName()] = $filter;
    }

    public static function getFilterByName(string $filterName) : ?TemplateFilter
    {
        return self::$filters[$filterName] ?? null;
    }


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



    public function parse(array $scope = []) {
        $content = $this->getOriginalContent();

        $parser = new PhoreTemplateParser(explode("\n", $content));



    }








}
