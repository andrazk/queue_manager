<?php

namespace Worker\Tests;

use Worker\Encoder;

class EncoderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test if correctly hashed
     * @return void
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function testPasswordHash()
    {
        $pass = 'rasmuslerdorf';

        $worker = new Encoder();

        $this->assertTrue(password_verify($pass, $worker->run(1, 2, $pass)));
    }
}
