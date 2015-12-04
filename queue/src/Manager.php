<?php

namespace Queue;

class Manager
{
    /**
     * @var StorageInterface
     */
    protected $storage;

    /**
     * Class Construct
     * @param  StorageInterface $storage
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
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
}
