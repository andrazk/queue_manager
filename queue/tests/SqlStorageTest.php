<?php

namespace Queue\Tests;

use Queue\SqlStorage;
use Queue\Worker;
use Queue\Task;

class SqlStorageTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->storage = new SqlStorage('test.sqlite');
    }

    /**
     * Test getter from workers file
     * @return void
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function testGetWorkers()
    {
        $data = ['workers' => [new Worker()]];
        $storage = \Mockery::mock('Queue\SqlStorage[getFile,open]');
        $storage->shouldReceive('getFile')->once()->andReturn($this->fileInTest);
        $storage->shouldReceive('open')->with($this->fileInTest)->once()->andReturn($data);

        $workers = $storage->getWorkers();

        $this->assertInstanceOf('Queue\Worker', $workers[0]);
    }

    public function testGetWorkerByHost()
    {
        $host = "127.0.0.1";

        $worker = new Worker();
        $worker->setHost($host);
        $this->storage->saveWorker($worker);

        $this->assertEquals($worker, $this->storage->getWorkerByHost($host));
    }

    public function testGetWorkerByHostNotFound()
    {
        $host = "127.0.0.1";
        $hostPublic = "198.1.45.32";

        $worker = \Mockery::mock('Queue\Worker');
        $worker->shouldReceive('getHost')->once()->andReturn($host);
        $storage = \Mockery::mock('Queue\SqlStorage[getWorkers]');
        $storage->shouldReceive('getWorkers')->once()->andReturn([$worker]);

        $this->assertNull($storage->getWorkerByHost($hostPublic));
    }

    /**
     * Save new worker without id
     * @return void
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function testSaveNewWorker()
    {
        $worker = new Worker();
        $actual = $this->storage->saveWorker($worker);

        $this->assertEquals(1, $actual->getId());
    }

    /**
     * Save two works one after another
     * @return void
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function testSaveTwoWorkers()
    {
        $first = $this->storage->saveWorker(new Worker());
        $second = $this->storage->saveWorker(new Worker());

        $this->assertEquals(1, $first->getId());
        $this->assertEquals(2, $second->getId());
    }

    /**
     * Test if worker is updated
     * @return void
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function testUpdateWorker()
    {
        $worker = new Worker();
        $worker->setHost('127.0.0.1');
        $worker = $this->storage->saveWorker($worker);

        $workerUpdated = new Worker();
        $workerUpdated->setId($worker->getId());
        $workerUpdated->setHost('198.21.0.221');
        $this->storage->saveWorker($workerUpdated);

        $actual = $this->storage->getWorkers()[0];

        $this->assertEquals('198.21.0.221', $actual->getHost());
    }

    /**
     * Tsest if task is saved
     * @return void
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function testSaveNewTask()
    {
        $task = new Task();
        $actual = $this->storage->saveTask($task);

        $this->assertEquals(1, $actual->getId());
    }

    /**
     * Test if id is incremented
     * @return void
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function testSaveTwoTasks()
    {
        $first = $this->storage->saveTask(new Task());
        $second = $this->storage->saveTask(new Task());

        $this->assertEquals(1, $first->getId());
        $this->assertEquals(2, $second->getId());
    }

    /**
     * Test if task is updated
     * @return void
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function testUpdateTask()
    {
        $task = new Task();
        $task->setStatus('in_progress');
        $task = $this->storage->saveTask($task);

        $task->setStatus('done');
        $this->storage->saveTask($task);

        $actual = $this->storage->getTasks()[0];

        $this->assertEquals('done', $actual->getStatus());
    }

    /**
     * Do some destruction after each test
     * @return void
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function tearDown()
    {
        parent::tearDown();

        if (file_exists('test.sqlite')) {
            unlink('test.sqlite');
        }
    }
}
