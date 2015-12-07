<?php

namespace Worker;

class Fibonacci extends Worker
{
    protected $cache = [];

    /**
     * Return Fibonacci sequence
     * @param  string $workerId
     * @param  string $taskId
     * @param  string $input
     * @return string
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function run($workerId, $taskId, $num)
    {
        $out = [];

        for ($ii = 0; $ii < $num; $ii++) {
            $out[] = $this->fib($ii);
        }

        $out = implode(', ', $out);

        $this->sendResult($workerId, $taskId, $out);

        return $out;
    }

    /**
     * Get fibonacci number for given index
     * @param  int $num
     * @return int
     * @author Andraz <andraz.krascek@gmail.com>
     */
    protected function fib($num)
    {
        if (isset($this->cache[$num])) {
            return $this->cache[$num];
        }

        $res = ($num < 2) ? $num : $this->fib($num - 1) + $this->fib($num - 2);

        $this->cache[$num] = $res;

        return $res;
    }
}
