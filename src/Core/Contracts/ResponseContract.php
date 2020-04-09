<?php

namespace Medic911\MVC\Core\Contracts;

/**
 * Interface ResponseContract
 * @package Medic911\MVC\Core\Contracts
 */
interface ResponseContract
{
    /**
     *
     */
    public function send(): void;
}