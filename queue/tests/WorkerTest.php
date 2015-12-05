<?php

namespace Queue\Tests;

use Queue\Worker;

class WorkerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function testSetGetId()
    {
        $worker = new Worker();
        $worker->setId(2200);

        $this->assertEquals(2200, $worker->getId());
    }

    /**
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function testSetGetHost()
    {
        $host = '127.0.0.1';

        $worker = new Worker();
        $worker->setHost($host);

        $this->assertEquals($host, $worker->getHost());
    }

    /**
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function testSetGetPort()
    {
        $port = '8080';

        $worker = new Worker();
        $worker->setPort($port);

        $this->assertEquals($port, $worker->getPort());
    }

    /**
     * Test type setter and getter
     * @return void
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function testSetGetType()
    {
        $type = 'fibonacci';

        $worker = new Worker();
        $worker->setType($type);

        $this->assertEquals($type, $worker->getType());
    }

    /**
     * Test if worker is free after set
     * @return void
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function testSetIsFree()
    {
        $worker = new Worker();
        $worker->setStatus('free');

        $this->assertTrue($worker->isFree());
    }

    /**
     * Test if worker is busy after set
     * @return void
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function testSetIsBusy()
    {
        $worker = new Worker();
        $worker->setStatus('busy');

        $this->assertTrue($worker->isBusy());
    }
}
