<?php

namespace Worker;

class Arithmetic extends Worker
{
    protected $parser;

    /**
     * Simple arithmetic solver
     * Using shunting-yard algorithm
     * @param  string $workerId
     * @param  string $taskId
     * @param  string $input
     * @return string
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function run($workerId, $taskId, $input)
    {
        file_put_contents('result.log', $input, FILE_APPEND);
        $result = \RR\Shunt\Parser::parse($input);
        file_put_contents('result.log', $result, FILE_APPEND);

        $this->sendResult($workerId, $taskId, $result);

        return $result;
    }
}
