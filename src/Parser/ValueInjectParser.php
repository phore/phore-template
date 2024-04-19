<?php
namespace Phore\Template\Parser;

use Phore\Template\PhoreTemplate;
use Phore\Template\Parser\Helper\ParserKit;
use Phore\Template\Pipe\FilterGroup;
use Phore\Template\TemplateFilter;

class ValueInjectParser
{

    public function __construct(
        /**
         * @var TemplateFilter[] $filters
         */
        private array $filters
    )
    {

    }



    protected function parseNextPart(string &$content, array $scope, int $index) : ?array {

        ParserKit::ReadWhitespace($content);
        if (ParserKit::IsNextCharAlphabetic($content) === false)
            return null;
        $name = ParserKit::ReadUntilToken($content, ["|", "}}", " "]);
        $args = [];
        ParserKit::ReadWhitespace($content);
        while (ParserKit::IsNextCharAlphabetic($content)) {
            $argName = ParserKit::ReadObject($content);
            $arg = ParserKit::ReadChar($content);
            if ($arg !== "=")
                throw new \InvalidArgumentException("Expected '=' after argument name '{$argName->value}' in function call");
            $argValue = ParserKit::ReadObject($content);
            $nextToken = ParserKit::ReadToken($content, ["|", "}}", " "]);
            $args[$argName->value] = $argValue->value;
        }
        return ["name" => trim ($name), "args" => $args];
    }

    protected function parseNext(string &$content, array $scope) : string {
        $output = ParserKit::ReadUntilToken($content, ["{{"]);



        if ($content === "")
            return $output; // No token found


        ParserKit::ReadToken($content, ["{{"]);

        $varName = null;


        $filterGroup = new FilterGroup();

        while ($curPart = $this->parseNextPart($content, $scope, 0)) {
            if ($varName === null) {
                // First element
                $varName = $curPart["name"];
                continue;
            }
            $filter = PhoreTemplate::getFilterByName($curPart["name"]);
            $filter->setArguments($curPart["args"]);
            $filterGroup->addFilter($filter);
        }
        ParserKit::ReadToken($content, ["}}"]);


        $value = $scope[$varName] ?? null;
        return $output . $filterGroup->perform($value);
    }


    public function parse(string $content, array $scope): string
    {
        $output = "";
        while ($part = $this->parseNext($content, $scope)) {
            $output .= $part;
        }
        return $output;

    }

}
?>
