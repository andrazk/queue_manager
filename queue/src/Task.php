<?php

namespace Queue;

class Task
{
    protected $id = null;
    protected $name = '';
    protected $parameters;
    protected $status = 'waiting';

    /**
     * Create new instance of Task
     * @return Task
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function newInstance()
    {
        return new static();
    }

    /**
     * ID Getter
     * @return int
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Id Setter
     * @param  int $id
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Name Setter
     * @param  string $name
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Parameters Setter
     * @param  mixed $parameters
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Name Getter
     * @return string
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Parameters Getter
     * @return mixed
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Status Setter
     * @param  string $status
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Status Getter
     * @return string
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Check if task is waiting
     * @return boolean
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function isWaiting()
    {
        return $this->getStatus() === 'waiting';
    }
}
