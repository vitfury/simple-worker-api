<?php

namespace Worker\Http;

class Request
{
    /**
     * @var string
     */
    public $processId;

    /**
     * @var string
     */
    public $source;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $requestData = json_decode(file_get_contents('php://input'), true);
        $this->processId = $requestData['processId'];
        $this->source = $requestData['source'];
    }

    /**
     * @throws RequestException
     */
    public function validate()
    {
        if (empty($this->processId)) {
            throw new RequestException('ProcessId is required');
        }

        if (empty($this->source)) {
            throw new RequestException('Source is required');
        }
    }
}
