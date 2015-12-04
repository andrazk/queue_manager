<?php

require __DIR__ . '/src/autoload.php';

$storage = new \Queue\FileStorage();
$manager = new \Queue\Manager($storage);

$server = new JsonRpc\Server($manager);
$server->receive();
