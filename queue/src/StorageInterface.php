<?php

namespace Queue;

interface StorageInterface
{
    public function getWorkerByHost($host);
    public function getWorker($id);
    public function getWorkers();
    public function saveWorker(Worker $worker);

    public function deleteTask($taskId);
    public function getTasks();
    public function saveTask(Task $task);
}
