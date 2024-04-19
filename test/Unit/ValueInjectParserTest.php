<?php
namespace Phore\test\Unit;
use Phore\Template\Parser\ValueInjectParser;
use PHPUnit\Framework\TestCase;

class ValueInjectParserTest extends TestCase
{
    public function testSingleTokenParse()
    {
        $filters = [];
        $parser = new ValueInjectParser($filters);
        $content = '{} test';
        $scope = ['name' => 'John'];
        $result = $parser->parse($content, $scope);
        $this->assertEquals('{} test', $result);
    }
    public function testParse()
    {
        $filters = [];
        $parser = new ValueInjectParser($filters);
        $content = '{{ name }} test';
        $scope = ['name' => 'John'];
        $result = $parser->parse($content, $scope);
        $this->assertEquals('John test', $result);
    }



    public function testMultiparse()
    {
        $filters = [];
        $parser = new ValueInjectParser($filters);
        $content = 'Mr {{ name }} is {{ age }} years';
        $scope = ['name' => 'John', "age"=> 20];
        $result = $parser->parse($content, $scope);
        $this->assertEquals('Mr John is 20 years', $result);
    }

}
?>
