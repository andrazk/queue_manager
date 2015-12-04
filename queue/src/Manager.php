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
     * @return int
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function listen($host, $port)
    {
        $workers = $this->storage->getWorkers();
        // find existing worker
        foreach ($workers as $worker) {
            if ($host === $worker->getHost()) {
                return $worker->getId();
            }
        }
        // save new worker
        $worker = new Worker();
        $worker->setHost($host);
        $worker->setPort($port);

        $this->storage->save($worker);

        return $worker->getId();
    }
}
