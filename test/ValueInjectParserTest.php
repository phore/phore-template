<?php
namespace Phore\test;
use Phore\Template\Parser\ValueInjectParser;
use PHPUnit\Framework\TestCase;

class ValueInjectParserTest extends TestCase
{
    public function testParse()
    {
        $filters = [];
        $parser = new ValueInjectParser($filters);
        $content = '{{ name }} test';
        $scope = ['name' => 'John'];
        $result = $parser->parse($content, $scope);
        $this->assertEquals('John test', $result);
    }
}
?>
