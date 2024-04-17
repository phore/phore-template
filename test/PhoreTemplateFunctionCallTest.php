<?php

namespace Phore\test;



use Phore\Template;

use PHPUnit\Framework\TestCase;



class PhoreTemplateFunctionCallTest extends TestCase

{



    public function testPhoreParseFunctionCallInvalidFormat()

    {

        $this->expectException(\Exception::class);

    }

}

?>
