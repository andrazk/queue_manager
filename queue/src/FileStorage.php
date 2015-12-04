<?php

namespace Queue;

class FileStorage implements StorageInterface
{
    protected $workersFile = 'workers';

    /**
     * Open file resource
     * @return Resource
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function open($file)
    {
        if (!file_exists($file)) {
            return fopen($file, 'w');
        }

        return fopen($file, 'r+');
    }

    /**
     * Close file resource
     * @param  Resource $resource
     * @return void
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function close($resource)
    {
        fclose($resource);
    }

    /**
     * Get all workers from file
     * @return array
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function getWorkers()
    {
        $workers = [];
        $workers_unserialized = $this->getFile($this->getWorkersFile());

        foreach ($workers_unserialized as $worker) {
            $workers[] = unserialize($worker);
        }

        return $workers;
    }

    /**
     * Open file, save lines to array and close
     * @param  string $file
     * @return array
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function getFile($file)
    {
        return file($file);
    }

    public function getWorkerByHost($host)
    {

    }

    public function saveWorker(Worker $worker)
    {

    }

    /**
     * Workers File Getter
     * @return string
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function getWorkersFile()
    {
        return $this->workersFile;
    }

    /**
     * Workers File Setter
     * @param  string $filename
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function setWorkersFile($filename)
    {
        // if (!file_exists($filename)) {
        //     throw new Exception("File $filename doesn't exists!", 1);
        // }

        $this->workersFile = $filename;
    }
}
