<?php

namespace Worker\Core\Worker;

use Worker\Core\Storage\Storage;
use Worker\Core\Console;
use Worker\Core\Storage\StorageException;

class BackgroundRemovalWorker implements Worker
{
    /**
     * @var Console
     */
    private $console;

    /**
     * @var Storage
     */
    private $storage;

    /**
     * BackgroundRemovalWorker constructor.
     * @param Console $console
     * @param Storage $storage
     */
    public function __construct(Console $console, Storage $storage)
    {
        $this->console = $console;
        $this->storage = $storage;
    }

    /**
     * @param $processId
     * @param $content
     * @return string
     * @throws WorkerException
     * @throws StorageException
     */
    public function run($processId, $content)
    {
        $sourcePath = $this->storage->storeSourceImage($processId, $content);

        $this->console
            ->setInputFile($sourcePath)
            ->setOutputFile($this->storage->generateOutputImagePath($processId))
            ->setNeuralModel('bbd-fastrcnn')
            ->setPrepMethod('rtb-bnb')
            ->setPostMethod('u2net')
            ->execute();

        $resultContent = $this->storage->getResultImage($processId);
        $this->storage->clear();

        return $resultContent;
    }
}
