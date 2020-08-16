<?php

namespace Worker\Core\Storage;

use Exception;

class StorageException extends Exception
{
    /**
     * StorageException constructor.
     * @param string $message
     * @return void
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
