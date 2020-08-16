<?php

namespace Worker\Core\Worker;

interface Worker {

    /**
     * @param string $processId
     * @param string $content
     * @return string
     */
    public function run($processId, $content);
}
