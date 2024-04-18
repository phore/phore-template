<?php
namespace Phore\test\Unit;
use Phore\Template\Parser\Helper\ObjectType;
use Phore\Template\Parser\Helper\ObjectTypeTypeEnum;
use Phore\Template\Parser\Helper\ParserKit;
use PHPUnit\Framework\TestCase;

class ParserKitTest extends TestCase
{
    public function testReadObject()
    {
        $input = "'test string' more data";
        $object = ParserKit::ReadObject($input);
        $this->assertInstanceOf(ObjectType::class, $object);
        $this->assertEquals(ObjectTypeTypeEnum::STRING, $object->type);
        $this->assertEquals('test string', $object->value);
        $this->assertEquals(' more data', $input);
    }
    public function testReadObjectWithEscapedQuotes()
    {
        $input = '"test \"quote\" string" more data';
        $object = ParserKit::ReadObject($input);
        $this->assertInstanceOf(ObjectType::class, $object);
        $this->assertEquals(ObjectTypeTypeEnum::STRING, $object->type);
        $this->assertEquals('test "quote" string', $object->value);
        $this->assertEquals(' more data', $input);
    }
    public function testReadUntilToken()
    {
        $input = "hello, world";
        $result = ParserKit::ReadUntilToken($input, [',']);
        $this->assertEquals('hello', $result);
        $this->assertEquals(', world', $input);
    }
    public function testReadToken()
    {
        $input = ", world";
        $token = ParserKit::ReadToken($input, [',']);
        $this->assertEquals(',', $token);
        $this->assertEquals(' world', $input);
    }
}
?>
