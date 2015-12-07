<?php

namespace Worker;

class Mirror extends Worker
{
    /**
     * Reverse mirrored text
     * @param  string $workerId
     * @param  string $taskId
     * @param  string $input
     * @return string
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function run($workerId, $taskId, $input)
    {
        $result = strrev($input);
        
        $this->sendResult($workerId, $taskId, $result);

        return $result;
    }
}
