<?php

namespace DI;

class Dependency
{

    /**
     * @var mixed
     */
    private $object;

    /**
     * @var bool
     */
    private $singleton;

    /**
     * @var callable
     */
    private $loader;

    /**
     * Dependency constructor.
     * @param callable $loader
     * @param bool $singleton
     */
    public function __construct(callable $loader, $singleton = true)
    {
        $this->singleton = (boolean) $singleton;
        $this->loader = $loader;
    }

    /**
     * @return mixed
     */
    public function get()
    {
        if (! $this->singleton) {
            return call_user_func($this->loader);
        }
        if ($this->object === null) {
            $this->object = call_user_func($this->loader);
        }

        return $this->object;
    }
}
