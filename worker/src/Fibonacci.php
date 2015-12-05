<?php

namespace Worker;

class Fibonacci
{
    protected $cache = [];

    /**
     * Return Fibonacci sequence
     * @param  int $num
     * @return array
     * @author Andraz <andraz@easistent.com>
     */
    public function run($num)
    {
        $out = [];

        for ($ii = 0; $ii < $num; $ii++) {
            $out[] = $this->fib($ii);
        }

        return $out;
    }

    /**
     * Get fibonacci number for given index
     * @param  int $num
     * @return int
     * @author Andraz <andraz@easistent.com>
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
