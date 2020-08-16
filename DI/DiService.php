<?php

namespace DI;

class DiService
{
    /**
     * @var DiContainer
     */
    private $container;

    /**
     * DiService constructor.
     */
    public function __construct()
    {
        $this->container = DiContainer::getInstance();
    }

    /**
     * @param string $identifier
     * @param callable $loader
     * @param bool $singleton
     */
    public function register($identifier, callable $loader, $singleton = true)
    {
        $this->container->add($identifier, $loader, $singleton);
    }

    /**
     * @param string $identifier
     * @return mixed
     * @throws \Exception
     */
    public function get($identifier)
    {
        return $this->container->get($identifier);
    }
}
