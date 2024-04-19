<?php

namespace Phore\test\Integration;

use PHPUnit\Framework\TestCase;

class TemplateTest extends TestCase
{


    public function testLoadFromFile() {

        $out = phore_template_file(__DIR__ . "/../mock/testfile.txt", ["name" => "John"])->render();
        $this->assertEquals("Name: John\n", $out);
    }

     public function testLoadHtml() {

        $expected = phore_file(__DIR__ . "/../mock/demo1.expected.txt")->get_contents();
        $out = phore_template_file(__DIR__ . "/../mock/demo1.input.html", ["js" => "some code", "name" => "john"])->render();
        $this->assertEquals($expected, $out);
    }
}
