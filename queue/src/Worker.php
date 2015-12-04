<?php

namespace Queue;

class Worker
{
    protected $id = null;
    protected $host = null;
    protected $port = null;

    /**
     * Get Id Value
     * @return int
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get Host Value
     * @return string
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Get Port Value
     * @return string
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Set Id Value
     * @return int
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Set Host Value
     * @return string
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * Set Port Value
     * @return string
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function setPort($port)
    {
        $this->port = $port;
    }
}
