<?php

namespace Worker;

class Encoder
{
    /**
     * Encode input with PASSWORD_BCRYPT algorithm
     * @param  string $input
     * @return string
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function run($input)
    {
        return password_hash($input, PASSWORD_BCRYPT);
    }
}
