<?php

require __DIR__ . '/vendor/autoload.php';

$queueHost = getenv('QUEUE_PORT_8000_TCP_ADDR');
$queueUrl = "http://$queueHost:8000/listen.php";

$client = new JsonRpc\Client($queueUrl);
$client->call('enqueueTask', ['encoder', 5]);

