<?php

namespace Medic911\MVC\Core\Contracts;

/**
 * Interface RequestContract
 * @package Medic911\MVC\Core\Contracts
 */
interface RequestContract
{
    /**
     * @return string
     */
    public function getPath(): string;
}