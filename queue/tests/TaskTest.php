<?php

namespace Queue\Tests;

use Queue\Task;

class TaskTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test if new instance of task is created
     * @return void
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function testNewInstance()
    {
        $task = new Task();
        $instance = $task->newInstance();

        $this->assertInstanceOf('Queue\Task', $instance);
        $this->assertNotSame($task, $instance);
    }

    /**
     * Test if name is set and returned
     * @return void
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function testSetGetName()
    {
        $name = 'fibonacci';
        $task = new Task();
        $task->setName($name);

        $this->assertSame($name, $task->getName());
    }

    /**
     * Test if parameters are set and returned
     * @return void
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function testSetGetParameters()
    {
        $parameters = '(1+2)*3';
        $task = new Task();
        $task->setParameters($parameters);

        $this->assertSame($parameters, $task->getParameters());
    }
}
