<?php

require __DIR__ . '/vendor/autoload.php';

class DummyResponder
{
    /**
     * Listen to worker
     * @param  string  $host
     * @param  integer $port
     * @return string
     * @author Andraz <andraz@easistent.com>
     */
    public function listen($host, $port = 4000)
    {
        return "Welcome $host on port $port";
    }
}

$methods = new DummyResponder();
$server = new JsonRpc\Server($methods);
$server->receive();
