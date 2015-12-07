<?php

namespace Worker;

class Worker
{
    /**
     * When task finished send result back to queue
     * @param  string $workerId
     * @param  string $taskId
     * @param  mixed $result
     * @return boolean
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function sendResult($workerId, $taskId, $result)
    {
        $client = new \JsonRpc\Client($this->getQueueUrl() . 'listen.php');
        return $client->call('done', [$workerId, $taskId, $result]);
    }

    /**
     * Resolve queue host and port
     * @return string
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function getQueueUrl()
    {
        $queueHost = getenv('QUEUE_PORT_8000_TCP_ADDR');
        return "http://$queueHost:8000/";
    }

    /**
     * Send request to queue
     * @return boolean
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function startListening()
    {
        $client = new \JsonRpc\Client($this->getQueueUrl() . 'listen.php');
        $client->call('listen', [$this->getIp(), $this->getPort(), $this->getType()]);
    }

    /**
     * Resolve worker IP
     * @return string
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function getIp()
    {
        $id = gethostname();
        return gethostbyname($id);
    }

    /**
     * Resolve worker port
     * @return int
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function getPort()
    {
        return getenv('WORKER_PORT');
    }

    /**
     * Resolve worker type
     * @return string
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function getType()
    {
        return getenv('WORKER_TYPE');
    }
}
