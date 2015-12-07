<?php

require __DIR__ . '/src/autoload.php';

unlink('queue.sqlite');

file_put_contents('result.log', '--start--' . PHP_EOL);

$storage = new \Queue\SqlStorage();

$task = new \Queue\Task();

$manager = new \Queue\Manager($storage, $task);

while (true) {

    list($task, $worker) = $manager->getWaitingTaskAndFreeWorker();

    if ($task) {
        $manager->sendTaskToWorker($task, $worker);
    }
}
