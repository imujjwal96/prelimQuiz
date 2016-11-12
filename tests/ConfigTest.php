<?php

class ConfigTest extends PHPUnit_Framework_TestCase
{
    public function testSample() {
        $this->assertNotTrue("1-2-ka-4" == "4-2-ka-1" , "Testing");
    }
}
