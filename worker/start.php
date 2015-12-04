<?php

require __DIR__ . '/vendor/autoload.php';

// resolve queue host and port
$queueHost = getenv('QUEUE_PORT_8000_TCP_ADDR');
$queueUrl = "http://$queueHost:8000/listen.php";
echo $queueUrl . PHP_EOL;

// worker resolve instance host
$id = gethostname();
$ip = gethostbyname($id);
$port = getenv('WORKER_PORT');
$type = getenv('WORKER_TYPE');

// start listening
$client = new JsonRpc\Client($queueUrl);
$success = $client->call('listen', [$ip, $port, $type]);

echo $success . PHP_EOL;
var_dump($client->response);
var_dump($client->error);

