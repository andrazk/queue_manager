<?php

namespace Worker\Tests;

use Worker\Mirror;

class MirrorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test reverse text
     * @return void
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function testRun()
    {
        $input = '.di tU .tile gnicsipida rutetcesnoc ,tema tis rolod muspi meroL';
        $expected = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut id.';

        $worker = new Mirror();

        $this->assertEquals($expected, $worker->run(1, 2, $input));
    }
}
