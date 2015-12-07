<?php

namespace Worker\Tests;

use Worker\Arithmetic;

class ArithmeticTest extends \PHPUnit_Framework_TestCase
{
    public function testSimpleArithmetic()
    {
        $input = '3 + 4 * 2 / ( 1 - 5 ) ^ 2 ^ 3';
        $res = 3.0001220703125;

        $worker = new Arithmetic();

        $this->assertEquals($res, $worker->run(1, 2, $input));
    }
}
