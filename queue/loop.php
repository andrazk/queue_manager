<?php

require __DIR__ . '/src/autoload.php';

unlink('queue.sqlite');
unlink('result.log');

$storage = new \Queue\SqlStorage();

$task = new \Queue\Task();

$manager = new \Queue\Manager($storage, $task);

while (true) {

    echo 'Number of tasks: ' .count($storage->getTasks()) . PHP_EOL;
    echo 'Number of worke: ' . count($storage->getWorkers()) . PHP_EOL;

    list($task, $worker) = $manager->getWaitingTaskAndFreeWorker();

    if ($task) {
        $manager->sendTaskToWorker($task, $worker);
    }

    echo '---' . PHP_EOL;

    sleep(1);
}
