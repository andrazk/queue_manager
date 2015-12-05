<?php

namespace Worker;

class Mirror
{
    /**
     * Reverse mirrored text
     * @param  string $input
     * @return string
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function run($input)
    {
        return strrev($input);
    }
}
