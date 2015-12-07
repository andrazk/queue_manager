<?php

namespace Queue;

class FileStorage implements StorageInterface
{
    protected $file = '/usr/src/storage_file';

    /**
     * File Getter
     * @return string
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * File Setter
     * @param  string $file
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * Open file resource
     * @return array
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function open($file)
    {
        if (!file_exists($file)) {
            return [];
        }

        return unserialize(file_get_contents($file));
    }

    /**
     * Get single worker by id
     * @param  int $workerId
     * @return Worker|null
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function getWorker($workerId)
    {
        $workers = $this->getWorkers();
        if (isset($workers[$workerId])) {
            return $workers[$workerId];
        }

        return null;
    }

    /**
     * Get all workers from file
     * @return array
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function getWorkers()
    {
        $data = $this->open($this->getFile());

        return $this->getKeyFromData($data, 'workers');
    }

    /**
     * Find worker by host attribute
     * @param  string $host
     * @return Worker|null
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function getWorkerByHost($host)
    {
        $workers = $this->getWorkers();

        foreach ($workers as $worker) {
            if ($host === $worker->getHost()) {
                return $worker;
            }
        }
    }

    /**
     * Get key from data
     * @param  array $data
     * @param  string $key
     * @return mixed
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function getKeyFromData($data, $key)
    {
        if (!is_array($data)) {
            return [];
        }

        if (!key_exists($key, $data)) {
            return [];
        }

        return $data[$key];
    }

    /**
     * Save worker to file
     * @param  Worker $worker
     * @return Worker
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function saveWorker(Worker $worker)
    {
        $data = $this->open($this->getFile());
        $workers = $this->getKeyFromData($data, 'workers');

        if (is_null($worker->getId())) {
            $worker->setId(count($workers));
        }

        $workers[$worker->getId()] = $worker;

        $data['workers'] = $workers;

        $this->write($this->getFile(), $data);

        return $worker;
    }

    /**
     * Write to file
     * @param  string $file
     * @param  array $data
     * @return int|false
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function write($file, $data)
    {
        file_put_contents('log', 'File: ' . $file . PHP_EOL, FILE_APPEND);
        return file_put_contents($file, serialize($data));
    }

    /**
     * Get tasks from file
     * @return array
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function getTasks()
    {
        $data = $this->open($this->getFile());
        return $this->getKeyFromData($data, 'tasks');
    }

    /**
     * Delete task from storage
     * @param  int $taskId
     * @return boolean
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function deleteTask($taskId)
    {
        $data = $this->open($this->getFile());
        $tasks = $this->getKeyFromData($data, 'tasks');

        if (!isset($tasks[$taskId])) {
            return false;
        }

        unset($tasks[$taskId]);

        $data['tasks'] = $tasks;

        $this->write($this->getFile(), $data);

        return true;
    }

    /**
     * Insert or update task in file
     * @param  Task $task
     * @return Task
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function saveTask(Task $task)
    {
        $data = $this->open($this->getFile());
        $tasks = $this->getKeyFromData($data, 'tasks');

        if (is_null($task->getId())) {
            $id = 0;
            if (!empty($tasks)) {
                $id = max(array_keys($tasks)) + 1;
            }

            $task->setId($id);
        }

        $tasks[$task->getId()] = $task;

        $data['tasks'] = $tasks;

        $this->write($this->getFile(), $data);

        return $task;
    }
}
