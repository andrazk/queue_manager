<?php

require __DIR__ . '/../vendor/autoload.php';

class DummyListener()
{
    /**
     * Echo queue result
     * @param  int   $id
     * @param  string   $method
     * @param  mixed   $result
     * @return function
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function done($id, $method, $result)
    {
        echo "Task $method [$id] finished with result: $result" . PHP_EOL;
    }
}


$server = new JsonRpc\Server(new DummyListener());
$server->receive();
