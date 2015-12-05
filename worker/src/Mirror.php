<?php

namespace Worker;

class Mirror
{
    /**
     * Reverse mirrored text
     * @param  string $input
     * @return string
     * @author Andraz <andraz@easistent.com>
     */
    public function run($input)
    {
        return strrev($input);
    }
}
