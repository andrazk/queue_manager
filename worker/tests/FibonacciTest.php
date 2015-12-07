<?php

namespace Worker\Tests;

use Worker\Fibonacci;

class FibonacciTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test fibonacci sequence
     * @return void
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function testRun()
    {
        $worker = new Fibonacci();

        $this->assertEquals('', $worker->run(1, 2, 0));
        $this->assertEquals('0', $worker->run(1, 2, 1));
        $this->assertEquals('0, 1, 1, 2, 3, 5', $worker->run(1, 2, 6));
    }
}
