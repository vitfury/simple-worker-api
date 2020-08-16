<?php

namespace Worker\Http;

use Worker\Core\Worker\Worker;
use Worker\Core\Storage\StorageException;
use Worker\Core\Worker\WorkerException;
use Worker\Http\RequestException;
use Throwable;

class Controller {

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Response
     */
    private $response;

    /**
     * @var Worker
     */
    private $worker;

    /**
     * @var int
     */
    private $code;

    /**
     * Controller constructor.
     * @param Request $request
     * @param Response $response
     * @param Worker $worker
     */
    public function __construct(Request $request, Response $response, Worker $worker)
    {
        $this->request = $request;
        $this->response = $response;
        $this->worker = $worker;
        $this->code = 200;
    }

    /**
     * @return void
     */
    public function index()
    {
        try {
            $this->request->validate();
            $content = base64_decode($this->request->source);
            if ($content === false) {
                throw new RequestException('Wrong source encoding');
            }
            $resultImage = $this->worker->run($this->request->processId, $content);
            $this->response->setResult(!empty($resultImage))
                ->setData(['content' => base64_encode($resultImage)])
                ->setMessage('Converted successfully');
        } catch (RequestException $e) {
            $this->code = 400;
            $this->response->setMessage('Request exception: ' . $e->getMessage());
        } catch (StorageException $e) {
            $this->code = 500;
            $this->response->setMessage('Storage has failed: ' . $e->getMessage());
        } catch (WorkerException $e) {
            $this->code = 500;
            $this->response->setMessage('Worker has failed: ' . $e->getMessage());
            $this->response->setError($e->fullError());
        } catch (Throwable $e) {
            $this->code = 503;
            $this->response->setMessage('Unhandled exception: ' . $e->getMessage());
        } finally {
            http_response_code($this->code);
            echo $this->response;
        }
    }
}

