<?php

namespace Medic911\MVC\Core\Contracts;

use Medic911\MVC\Core\Exceptions\NotFoundTemplateException;

/**
 * Interface ViewContract
 * @package Medic911\MVC\Core\Contracts
 */
interface ViewContract
{
    /**
     * @return string
     * @throws NotFoundTemplateException
     */
    public function render(): string;
}