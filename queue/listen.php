<?php

require __DIR__ . '/src/autoload.php';

$storage = new \Queue\FileStorage();
$task = new \Queue\Task();

$manager = new \Queue\Manager($storage, $task);

$server = new JsonRpc\Server($manager);
$server->receive();
