<?php

namespace Queue\Tests;

use Queue\FileStorage;
use Queue\Worker;

class FileStorageTest extends \PHPUnit_Framework_TestCase
{
    protected $fileInTest = './tests/file_in_test';

    public function setUp()
    {
        parent::setUp();

        $this->storage = new FileStorage();
    }

    /**
     * Test opening not existing file
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function testOpen()
    {
        $this->storage->open($this->fileInTest);

        $this->assertTrue(file_exists($this->fileInTest));
    }

    /**
     * Test setter and getter for worker file
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function testSetGetWorkerFile()
    {
        $file = './workerfile';

        $this->storage->setWorkersFile($file);

        $this->assertEquals($file, $this->storage->getWorkersFile());
    }

    /**
     * Test getter from workers file
     * @return void
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function testGetWorkers()
    {
        $worker = serialize(new Worker());

        $storage = \Mockery::mock('Queue\FileStorage[getFile,getWorkersFile]');
        $storage->shouldReceive('getWorkersFile')->once()->andReturn($this->fileInTest);
        $storage->shouldReceive('getFile')->with($this->fileInTest)->once()->andReturn([$worker]);

        $workers = $storage->getWorkers();

        $this->assertInstanceOf('Queue\Worker', $workers[0]);
    }

    /**
     * Test if function return array from file
     * @return void
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function testGetFile()
    {
        file_put_contents($this->fileInTest, "a\nb");

        $actual = $this->storage->getFile($this->fileInTest);

        $this->assertCount(2, $actual);
    }

    public function tearDown()
    {
        parent::tearDown();

        if (file_exists($this->fileInTest)) {
            unlink($this->fileInTest);
        }
    }
}
