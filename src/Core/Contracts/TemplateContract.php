<?php

namespace Medic911\MVC\Core\Contracts;

use Medic911\MVC\Core\Exceptions\CompileTemplateException;
use Medic911\MVC\Core\Exceptions\NotFoundTemplateException;

/**
 * Interface TemplateContract
 * @package Medic911\MVC\Core\Contracts
 */
interface TemplateContract
{
    /**
     * @return string
     * @throws NotFoundTemplateException
     * @throws CompileTemplateException
     */
    public function render(): string;
}