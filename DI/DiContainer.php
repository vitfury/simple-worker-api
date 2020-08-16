<?php

namespace DI;

use Exception;

class DiContainer
{

    /**
     * @var self
     */
    private static $instance;

    /**
     * @var array
     */
    private $dependencies;

    /**
     * DiContainer constructor.
     */
    private function __construct()
    {
        $this->dependencies = [];
    }

    /**
     * @return self
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param string $identifier
     * @param callable $loader
     * @param bool $singleton
     */
    public function add($identifier, callable $loader, $singleton = true)
    {
        $this->dependencies[$identifier] = new Dependency($loader, $singleton);
    }

    /**
     * @param $identifier
     * @return mixed
     * @throws Exception
     */
    public function get($identifier)
    {
        if (!isset($this->dependencies[$identifier])) {
            throw new Exception(
                "Dependency identified by '$identifier' does not exist"
            );
        }
        return $this->dependencies[$identifier]->get();
    }
}
