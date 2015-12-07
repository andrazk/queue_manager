<?php

require __DIR__ . '/vendor/autoload.php';

$queueHost = getenv('QUEUE_PORT_8000_TCP_ADDR');
$queueUrl = "http://$queueHost:8000/listen.php";

$tasks = [
	['fibonacci', 5],
	['fibonacci', 1],
	['fibonacci', 10],
	['mirror', 'muspi meroL'],
	['mirror', '.alib akšrU ej cilked zi išpelran ,altevs acinad ej dzevz zi jlobrán oK - .enež en atelked ajtevc ejn usač bo eneležaz jlob olib mečo enebon ,enebon in olib ekšrU do išpel la,elevols eknajlbujL os épel jedkén dO'],
	['encoder', 'my-secret-password'],
	['encoder', '123456'],
	['arithmetic', '3 + 4 * 2 / ( 1 - 5 ) ^ 2 ^ 3'],
	['arithmetic', '2 * 4 + 5'],
];

sleep(3);

for ($ii = 0; $ii < 100; $ii++) {

	$key = array_rand($tasks);

	$client = new JsonRpc\Client($queueUrl);
	$client->call('enqueueTask', $tasks[$key]);

	usleep(rand(100000, 1000000));
}

