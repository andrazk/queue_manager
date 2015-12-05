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

    /**
     * Test if there are any Waiting task and free workers
     * @return void
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function testGetWaitingTaskAndFreeWorker()
    {
        $worker = \Mockery::mock('Queue\Worker');
        $worker->shouldReceive('getType')->once()->andReturn('fibonacci');
        $worker->shouldReceive('isBusy')->once()->andReturn(false);

        $task = \Mockery::mock('Queue\Task');
        $task->shouldReceive('isWaiting')->once()->andReturn(true);
        $task->shouldReceive('getType')->once()->andReturn('fibonacci');

        $storage = \Mockery::mock('Queue\FileStorage');
        $storage->shouldReceive('getTasks')->once()->andReturn([$task]);
        $storage->shouldReceive('getWorkers')->once()->andReturn([$worker]);

        $manager = new Manager($storage, $task);

        list($actualTask, $actualWorker) = $manager->getWaitingTaskAndFreeWorker();

        $this->assertEquals($task, $actualTask);
        $this->assertEquals($worker, $actualWorker);
    }

    /**
     * Test what happens if no waiting task
     * @return void
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function testGetNoWaitingTask()
    {
        $task = \Mockery::mock('Queue\Task');
        $task->shouldReceive('isWaiting')->once()->andReturn(false);

        $storage = \Mockery::mock('Queue\FileStorage');
        $storage->shouldReceive('getTasks')->once()->andReturn([$task]);

        $manager = new Manager($storage, $task);

        list($actualTask, $actualWorker) = $manager->getWaitingTaskAndFreeWorker();

        $this->assertNull($actualTask);
        $this->assertNull($actualWorker);
    }

    /**
     * Test what happens if no worker is same type
     * @return void
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function testGetWaitingTaskAndNoFreeWorkerOfSameType()
    {
        $worker = \Mockery::mock('Queue\Worker');
        $worker->shouldReceive('getType')->once()->andReturn('crypte');

        $task = \Mockery::mock('Queue\Task');
        $task->shouldReceive('isWaiting')->once()->andReturn(true);
        $task->shouldReceive('getType')->once()->andReturn('fibonacci');

        $storage = \Mockery::mock('Queue\FileStorage');
        $storage->shouldReceive('getTasks')->once()->andReturn([$task]);
        $storage->shouldReceive('getWorkers')->once()->andReturn([$worker]);

        $manager = new Manager($storage, $task);

        list($actualTask, $actualWorker) = $manager->getWaitingTaskAndFreeWorker();

        $this->assertNull($actualTask);
        $this->assertNull($actualWorker);
    }

    /**
     * Test what happens if no worker is free
     * @return void
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function testGetWaitingTaskAndNoFreeWorker()
    {
        $worker = \Mockery::mock('Queue\Worker');
        $worker->shouldReceive('getType')->once()->andReturn('fibonacci');
        $worker->shouldReceive('isBusy')->once()->andReturn(true);

        $task = \Mockery::mock('Queue\Task');
        $task->shouldReceive('isWaiting')->once()->andReturn(true);
        $task->shouldReceive('getType')->once()->andReturn('fibonacci');

        $storage = \Mockery::mock('Queue\FileStorage');
        $storage->shouldReceive('getTasks')->once()->andReturn([$task]);
        $storage->shouldReceive('getWorkers')->once()->andReturn([$worker]);

        $manager = new Manager($storage, $task);

        list($actualTask, $actualWorker) = $manager->getWaitingTaskAndFreeWorker();

        $this->assertNull($actualTask);
        $this->assertNull($actualWorker);
    }
}
