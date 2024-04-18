<?php

namespace Phore\Template;




use Phore\Template\Parser\ValueInjectParser;

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



    public function render(array $scope = null) : string {
        if ($scope === null)
            $scope = $this->data;
        $content = $this->getOriginalContent();

        $parser = new ValueInjectParser(self::$filters);
        return $parser->parse($content, $scope);
    }

}
