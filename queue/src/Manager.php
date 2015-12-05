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

    /**
     * Find in storage waiting task and free worker of same type
     * @return array|null
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function getWaitingTaskAndFreeWorker()
    {
        $tasks = $this->storage->getTasks();

        foreach ($tasks as $task) {
            if (!$task->isWaiting()) {
                continue;
            }

            $workers = $this->storage->getWorkers();

            foreach ($workers as $worker) {

                if ($task->getName() !== $worker->getType()) {
                    continue;
                }

                if ($worker->isBusy()) {
                    continue;
                }

                return [$task, $worker];
            }
        }

        return [null, null];
    }

    /**
     * Send task over RPC to worker
     * Mark task as in progress nad worker as busy
     * @param  Task   $task
     * @param  Worker $worker
     * @return void
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function sendTaskToWorker(Task $task, Worker $worker)
    {
        $client = $this->newRpcClient($worker->getHost(), $worker->getport());
        $success = $client->notify($task->getName(), [$task->getParameters()]);

        if ($success) {
            $task->setStatus('in_progress');
            $this->storage->saveTask($task);

            $worker->setStatus('busy');
            $this->storage->saveWorker($worker);
        }

        return $success;
    }

    /**
     * Create new RPC Client
     * @param  string $host
     * @param  int $port
     * @return JsonRpc\Client
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function newRpcClient($host, $port)
    {
        return new JsonRpc\Client("http://$host:$port/listen.php");
    }

}
