<?php

namespace Worker;

class Arithmetic
{
    protected $parser;

    public function __construct($parser)
    {
        $this->parser = $parser;
    }

    /**
     * Simple arithmetic solver
     * Using shunting-yard algorithm
     * @param  string $input
     * @return int
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function run($input)
    {
        return $this->parser->parse($input);
    }
}
