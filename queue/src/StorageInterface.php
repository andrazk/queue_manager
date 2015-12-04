<?php

namespace Queue;

interface StorageInterface
{
    public function getWorkerByHost($host);
    public function getWorkers();
    public function saveWorker(Worker $worker);
}
