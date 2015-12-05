<?php

namespace Queue;

class Task
{
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
}
