<?php

require __DIR__ . '/vendor/autoload.php';

$worker = new Worker\Worker();
$worker->startListening();

