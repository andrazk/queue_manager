<?php

namespace Worker;

class Encoder extends Worker
{
    /**
     * Encode input with PASSWORD_BCRYPT algorithm
     * @param  string $workerId
     * @param  string $taskId
     * @param  string $input
     * @return string
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function run($workerId, $taskId, $input)
    {
        $pass = password_hash($input, PASSWORD_BCRYPT);

        $this->sendResult($workerId, $taskId, $pass);

        return $pass;
    }
}
