<?php

namespace Medic911\MVC\Core\Contracts;

/**
 * Interface ViewContract
 * @package Medic911\MVC\Core\Contracts
 */
interface ViewContract
{
    /**
     * @return string
     */
    public function render(): string;
}