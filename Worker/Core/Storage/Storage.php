<?php

namespace Worker\Core\Storage;

class Storage
{
    const DEFAULT_FILENAME = 'image.png';

    const INPUT_FOLDER = 'input';
    const OUTPUT_FOLDER = 'output';

    /**
     * @var string
     */
    private $storagePath;

    /**
     * @var string
     */
    private $processId;

    /**
     * Storage constructor.
     * @param string $storagePath
     */
    public function __construct($storagePath)
    {
        $this->storagePath = $storagePath;
    }

    /**
     * @param string $processId
     */
    public function setProcessId($processId)
    {
        $this->processId = $processId;
    }

    /**
     * @param string $processId
     * @param string $content
     * @return string
     * @throws StorageException
     */
    public function storeSourceImage($processId, $content)
    {
        $sourceDestination = $this->generateImagePath($processId, self::INPUT_FOLDER);

        file_put_contents($sourceDestination, $content);

        return $sourceDestination;
    }

    /**
     * @param string $processId
     * @return string
     * @throws StorageException
     */
    public function generateOutputImagePath($processId)
    {
        return $this->generateImagePath($processId, self::OUTPUT_FOLDER);
    }

    /**
     * @param string $processId
     * @throws StorageException
     * @return string
     */
    public function getResultImage($processId)
    {
        return file_get_contents($this->generateOutputImagePath($processId));
    }

    /**
     * @return void
     */
    public function clear()
    {
        shell_exec('rm -rf'.$this->storagePath.'/*');
    }

    /**
     * @param string $processId
     * @param $type
     * @return string
     * @throws StorageException
     */
    private function generateImagePath($processId, $type)
    {
        if (!in_array($type, [
            self::INPUT_FOLDER,
            self::OUTPUT_FOLDER,
        ])) {
            throw new StorageException('Trying to get image path with wrong folder type - '.$type);
        }

        $tempFolder = $sourcePath = implode('/', [
            $this->storagePath,
            $processId,
            $type,
        ]);

        if (!is_dir($tempFolder)) {
            mkdir($tempFolder, 0777, true);
        }

        return $tempFolder . DIRECTORY_SEPARATOR . self::DEFAULT_FILENAME;
    }
}
