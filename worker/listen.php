<?php

require __DIR__ . '/src/autoload.php';

$type = ucfirst(strtolower(getenv('WORKER_TYPE')));
$class = "Worker\\$type";

$worker = new $class();

$server = new JsonRpc\Server($worker);
$server->receive();
