<?php

namespace Worker\Core\Worker;

use Exception;

class WorkerException extends Exception
{
    /**
     * @var string
     */
    private $fullError;

    /**
     * WorkerException constructor.
     * @param string $message
     * @param array $fullError
     */
    public function __construct($message, $fullError)
    {
        $this->fullError = implode('', $fullError);
        parent::__construct($message);
    }

    /**
     * @return string
     */
    public function fullError()
    {
        return $this->fullError;
    }
}
