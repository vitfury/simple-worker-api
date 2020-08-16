<?php

namespace Worker\Http;

class Response
{

    /**
     * @var array
     */
    private $data;

    /**
     * @var string
     */
    private $error;

    /**
     * @var string
     */
    private $message;

    /**
     * @var bool
     */
    private $result;

    public function __construct()
    {
        //intial value
        $this->result = false;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @param string $error
     * @return $this
     */
    public function setError($error)
    {
        $this->error = $error;
        return $this;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @param bool $result
     * @return $this
     */
    public function setResult($result)
    {
        $this->result = $result;
        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $response = [
            'result' => $this->result,
            'message' => $this->message,
            'data' => $this->data,
        ];
        if (!is_null($this->error)) {
            $response['error'] = $this->error;
        }
        return json_encode($response);
    }
}
