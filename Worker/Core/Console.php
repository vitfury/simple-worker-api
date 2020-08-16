<?php

namespace Worker\Core;

use Worker\Core\Worker\WorkerException;

class Console
{
    /**
     * @var string
     */
    private $rootFolder;

    /**
     * @var string
     */
    private $executeScript;

    /**
     * @var string
     */
    private $inputFile;

    /**
     * @var string
     */
    private $outputFile;

    /**
     * @var string
     */
    private $neuralModel;

    /**
     * @var string
     */
    private $prepMethod;

    /**
     * @var string
     */
    private $postMethod;

    /**
     * Console constructor.
     * @param string $rootFolder
     * @param string $executeScript
     */
    public function __construct($rootFolder, $executeScript)
    {
        $this->rootFolder = $rootFolder;
        $this->executeScript = $executeScript;
    }

    /**
     * @param $neuralModel
     * @return $this
     */
    public function setNeuralModel($neuralModel)
    {
        $this->neuralModel = $neuralModel;
        return $this;
    }

    /**
     * @param $postMethod
     * @return $this
     */
    public function setPostMethod($postMethod)
    {
        $this->postMethod = $postMethod;
        return $this;
    }

    /**
     * @param $prepMethod
     * @return $this
     */
    public function setPrepMethod($prepMethod)
    {
        $this->prepMethod = $prepMethod;
        return $this;
    }

    /**
     * @param $inputFile
     * @return $this
     */
    public function setInputFile($inputFile)
    {
        $this->inputFile = $inputFile;
        return $this;
    }

    /**
     * @param $outputFile
     * @return $this
     */
    public function setOutputFile($outputFile)
    {
        $this->outputFile = $outputFile;
        return $this;
    }

    /**
     * @throws WorkerException
     * @return void
     */
    public function execute()
    {
        $workerCommand = "cd $this->rootFolder && sudo python3 $this->executeScript -i $this->inputFile -o $this->outputFile -prep $this->prepMethod -postp $this->postMethod -m $this->neuralModel";
        exec($workerCommand.' 2>&1', $output, $code);
        if ($code !== 0) {
            throw new WorkerException('Script exited with code - '.$code, $output);
        }
    }
}
