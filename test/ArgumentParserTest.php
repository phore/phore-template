<?php
namespace Phore\test;

use Phore\Template;
use PHPUnit\Framework\TestCase;

class ArgumentParserTest extends TestCase
{
    public function testParseArguments()
    {
        $arguments = "arg1='value1' arg2='value2' arg3='val\"ue' arg4='val\'ue' arg5=0 arg6=1";
        $expected = [
            'arg1' => 'value1',
            'arg2' => 'value2',
            'arg3' => 'val"ue',
            'arg4' => "val'ue",
            'arg5' => 0,
            'arg6' => 1
        ];
        $result = phore_parse_arguments($arguments);
        $this->assertEquals($expected, $result);
    }


    public function testBreak()
    {

    }

}
?>
