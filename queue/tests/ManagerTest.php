<?php

namespace Queue\Tests;

use Queue\FileStorage;
use Queue\Worker;
use Queue\Manager;
use Queue\Task;

class ManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test if new worker is saved
     * @return void
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function testListenToNewWorker()
    {
        $host = '173.0.0.2';

        $worker = new Worker();
        $worker->setId(2);

        $storage = \Mockery::mock('Queue\FileStorage');
        $storage->shouldReceive('getWorkerByHost')->once()->with($host)->andReturn(null);
        $storage->shouldReceive('saveWorker')->once()->with(\Mockery::type('Queue\Worker'))->andReturn($worker);

        $manager = new Manager($storage, new Task());

        $id = $manager->listen($host, 4000, 'fibonacci');

        $this->assertEquals(2, $id);
    }

    /**
     * Test if existing worker is recognized
     * @return void
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function testListenToExistingWorker()
    {
        $host = '173.0.0.2';

        $worker = new Worker();
        $worker->setId(2);

        $storage = \Mockery::mock('Queue\FileStorage');
        $storage->shouldReceive('getWorkerByHost')->once()->with($host)->andReturn($worker);
        $storage->shouldReceive('saveWorker')->never();

        $manager = new Manager($storage, new Task());

        $id = $manager->listen($host, 4000, 'fibonacci');

        $this->assertEquals(2, $id);
    }

    /**
     * Test if task is added to queue
     * @return void
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function testEnqueueTask()
    {
        $task = \Mockery::mock('Queue\Task');
        $task->shouldReceive('newInstance')->once()->andReturn($task);
        $task->shouldReceive('setName')->with('fibonacci')->once();
        $task->shouldReceive('setParameters')->with(5)->once();

        $storage = \Mockery::mock('Queue\FileStorage');
        $storage->shouldReceive('saveTask')->with($task)->once()->andReturn($task);

        $manager = new Manager($storage, $task);

        $this->assertEquals(1, $manager->enqueueTask('fibonacci', 5));
    }
}
