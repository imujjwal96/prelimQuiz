<?php

use PQ\Controllers\Admin;

class AdminControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testSample() {
        $this->assertFalse("1-2-ka-4" == "4-2-ka-1" , "Testing");
    }
}