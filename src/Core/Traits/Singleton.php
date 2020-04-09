<?php

namespace Medic911\MVC\Core\Traits;

trait Singleton
{
    /**
     * @var self|null
     */
    protected static ?self $instance = null;

    /**
     * Singleton constructor.
     */
    private function __construct()
    {
        //
    }

    /**
     *
     */
    private function __clone()
    {
        //
    }

    /**
     *
     */
    protected function initialize(): void
    {
        //
    }

    /**
     * @return static
     */
    public static function getInstance(): self
    {
        if (!self::$instance) {
            self::$instance = new self();
            self::$instance->initialize();
        }

        return self::$instance;
    }
}