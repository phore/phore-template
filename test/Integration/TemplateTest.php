<?php

namespace Phore\test\Integration;

use PHPUnit\Framework\TestCase;

class TemplateTest extends TestCase
{


    public function testLoadFromFile() {

        $out = phore_template_file(__DIR__ . "/../mock/testfile.txt", ["name" => "John"])->render();
        $this->assertEquals("Name: John\n", $out);
    }

}
