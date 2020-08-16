<?php

namespace Worker\Http;

use Exception;

class RequestException extends Exception
{
    /**
     * RequestException constructor.
     * @param string $message
     * @return void
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
