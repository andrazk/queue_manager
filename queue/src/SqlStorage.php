<?php

namespace Queue;

class SqlStorage implements StorageInterface
{
	protected $db;

	public function __construct($file = null)
	{
        if (is_null($file)) {
            $file = 'queue.sqlite';
        }

		$this->db = new \PDO('sqlite:' . $file);

		$this->db->exec("CREATE TABLE IF NOT EXISTS workers(id INTEGER PRIMARY KEY, host TEXT, port TEXT, type TEXT, status TEXT)");
		$this->db->exec("CREATE TABLE IF NOT EXISTS tasks(id INTEGER PRIMARY KEY, name TEXT, parameters TEXT, status TEXT)");
	}

    /**
     * Get worker by host
     * @param string $host
     * @return Worker null
     */
	public function getWorkerByHost($host)
	{
        if (!$result = $this->db->query("SELECT * FROM workers WHERE host = '$host' LIMIT 1")) {
            var_dump($this->db->errorInfo());
        }

		foreach ($result as $key => $row) {
    		$worker = new Worker();
    		$worker->setId($row['id']);
    		$worker->setHost($row['host']);
    		$worker->setPort($row['port']);
    		$worker->setType($row['type']);
    		$worker->setStatus($row['status']);

    		return $worker;
    	}

    	return null;
	}

    /**
     * Get worker by id
     * @param int $id
     * @return Worker null
     */
    public function getWorker($id)
    {
    	$result = $this->db->query("SELECT * FROM workers WHERE id = $id");

    	foreach ($result as $key => $row) {
    		$worker = new Worker();
    		$worker->setId($row['id']);
    		$worker->setHost($row['host']);
    		$worker->setPort($row['port']);
    		$worker->setType($row['type']);
    		$worker->setStatus($row['status']);

    		return $worker;
    	}

    	return null;
    }	

    /**
     * Sget all workers from DB
     * @return array
     */
    public function getWorkers()
    {
    	$result = $this->db->query("SELECT * FROM workers");

    	$workers = [];

    	foreach ($result as $key => $worker) {
    		$workers[$key] = new Worker();
    		$workers[$key]->setId($worker['id']);
    		$workers[$key]->setHost($worker['host']);
    		$workers[$key]->setPort($worker['port']);
    		$workers[$key]->setType($worker['type']);
    		$workers[$key]->setStatus($worker['status']);
    	}

    	return $workers;
    }

    /**
     * Save or update worker
     * @param Worker $worker
     * @return Worker
     */
    public function saveWorker(Worker $worker)
    {
    	if (is_null($worker->getId())) {
            $query = $this->db->prepare("INSERT INTO workers (host, port, type, status) VALUES (?, ?, ?, ?)");

    		$query->execute([$worker->getHost(), $worker->getPort(), $worker->getType(), $worker->getStatus()]);

    		$worker->setId($this->db->lastInsertId());
    	} else {
            file_put_contents('storage.log', print_r($worker, true), FILE_APPEND);
            $query = $this->db->prepare("UPDATE workers SET host = ?, port = ?, type = ?, status = ? WHERE id = ?");
            $query->execute([$worker->getHost(), $worker->getPort(), $worker->getType(), $worker->getStatus(), $worker->getId()]);
    	}

    	return $worker;
    }

    /**
     * Delete task from DB
     * @param int $taskId
     * @return boolean
     */
    public function deleteTask($taskId)
    {
    	return $this->db->exec("DELETE FROM tasks WHERE id = $taskId");
    }

    /**
     * Get all tasks from DB
     * @return array
     */
    public function getTasks()
    {
    	$result = $this->db->query("SELECT * FROM tasks");

    	$tasks = [];

    	foreach ($result as $key => $task) {
    		$tasks[$key] = new Task();
    		$tasks[$key]->setId($task['id']);
    		$tasks[$key]->setName($task['name']);
    		$tasks[$key]->setParameters($task['parameters']);
    		$tasks[$key]->setStatus($task['status']);
    	}

    	return $tasks;
    }

    /**
     * Save or update task
     * @param Task $task
     * @return Task
     */
    public function saveTask(Task $task)
    {
    	if (is_null($task->getId())) {
    		$query = $this->db->prepare("INSERT INTO tasks (name, parameters, status) VALUES (?, ?, ?)");
            $query->execute([$task->getName(), $task->getParameters(), $task->getStatus()]);

    		$task->setId($this->db->lastInsertId());
    	} else {
    		$query = $this->db->prepare("UPDATE tasks SET name = ?, parameters = ?, status = ? WHERE id = ?");
            $query->execute([$task->getName(), $task->getParameters(), $task->getStatus(), $task->getId()]);
    	}

    	return $task;
    }

}