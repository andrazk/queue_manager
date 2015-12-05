<?php

namespace Queue\Tests;

use Queue\FileStorage;
use Queue\Worker;
use Queue\Task;

class FileStorageTest extends \PHPUnit_Framework_TestCase
{
    protected $fileInTest = './tests/file_in_test';

    public function setUp()
    {
        parent::setUp();

        $this->storage = new FileStorage();
        $this->storage->setFile($this->fileInTest);
    }

    /**
     * Test opening not existing file
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function testOpen()
    {
        $data = ['key' => new \stdClass()];
        file_put_contents($this->fileInTest, serialize($data));

        $actual = $this->storage->open($this->fileInTest);

        $this->assertEquals($data, $actual);
    }

    /**
     * Test getter from workers file
     * @return void
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function testGetWorkers()
    {
        $data = ['workers' => [new Worker()]];

        $storage = \Mockery::mock('Queue\FileStorage[getFile,open]');
        $storage->shouldReceive('getFile')->once()->andReturn($this->fileInTest);
        $storage->shouldReceive('open')->with($this->fileInTest)->once()->andReturn($data);

        $workers = $storage->getWorkers();

        $this->assertInstanceOf('Queue\Worker', $workers[0]);
    }

    /**
     * Test if function return array from file
     * @return void
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function testSetGetFile()
    {
        $this->storage->setFile($this->fileInTest);
        $actual = $this->storage->getFile($this->fileInTest);

        $this->assertEquals($this->fileInTest, $actual);
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

        $this->assertEquals(0, $actual->getId());
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

        $this->assertEquals(0, $first->getId());
        $this->assertEquals(1, $second->getId());
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

        $this->assertEquals(0, $actual->getId());
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

        $this->assertEquals(0, $first->getId());
        $this->assertEquals(1, $second->getId());
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

        $taskUpdated = new Task();
        $taskUpdated->setId($task->getId());
        $taskUpdated->setStatus('done');
        $this->storage->saveTask($taskUpdated);

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

        if (file_exists($this->fileInTest)) {
            unlink($this->fileInTest);
        }
    }
}
