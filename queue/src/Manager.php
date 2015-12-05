<?php

namespace Queue;

class Manager
{
    /**
     * @var StorageInterface
     */
    protected $storage;

    /**
     * @var Task
     */
    protected $task;

    /**
     * Class Construct
     * @param  StorageInterface $storage
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function __construct(StorageInterface $storage, Task $task)
    {
        $this->storage = $storage;
        $this->task = $task;
    }

    /**
     * Listen to new workers and add them to queue
     * @param  string $host
     * @param  string $port
     * @param  string $type
     * @return int
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function listen($host, $port, $type)
    {
        if ($worker = $this->storage->getWorkerByHost($host)) {
            return $worker->getId();
        }

        // save new worker
        $worker = new Worker();
        $worker->setHost($host);
        $worker->setPort($port);
        $worker->setType($type);

        $worker = $this->storage->saveWorker($worker);

        return $worker->getId();
    }

    /**
     * Add new task to queue
     * @param  string $name
     * @param  mixed $parameters
     * @return int
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function enqueueTask($name, $parameters)
    {
        $task = $this->task->newInstance();
        $task->setName($name);
        $task->setParameters($parameters);

        $this->storage->saveTask($task);

        return 1;
    }

}
