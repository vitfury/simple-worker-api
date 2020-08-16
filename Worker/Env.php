<?php

namespace Worker;

class Env
{
    public $rootFolder;
    public $executeScript;
    public $storagePath;

    public function __construct()
    {
        $this->rootFolder = '/app';
        $this->executeScript = 'main.py';
        $this->storagePath = '/tmp/worker';
    }
}
