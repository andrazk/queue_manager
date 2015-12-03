<?php

require __DIR__ . '/vendor/autoload.php';

// resolve queue host and port
$queueHost = getenv('QUEUE_PORT_8000_TCP_ADDR');
$queueUrl = "http://$queueHost:8000/listen.php";
echo $queueUrl . PHP_EOL;

// worker resolve instance host
$id = gethostname();
$ip = gethostbyname($id);
$port = 4000;

// start listening
$client = new JsonRpc\Client($queueUrl);
$client->call('listen', [$ip, $port]);

