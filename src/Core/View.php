<?php

namespace Medic911\MVC\Core;

use Illuminate\Support\Str;
use Medic911\MVC\Core\Contracts\ViewContract;
use Medic911\MVC\Core\Exceptions\TemplateNotFoundException;

/**
 * Class View
 * @package Medic911\MVC\Core
 */
class View implements ViewContract
{
    /**
     * @var string
     */
    protected string $templatePath;

    /**
     * @var array
     */
    protected array $vars;

    /**
     * View constructor.
     * @param string $templateName
     * @param array $vars
     */
    public function __construct(string $templateName, array $vars = [])
    {
        $this->templatePath = BASE_DIR . '/src/Templates/' . $this->normalizeTemplateName($templateName);
        $this->vars = $vars;

        $this->normalizeTemplatePath();
        $this->normalizeOutput();
    }

    /**
     * @return string
     * @throws TemplateNotFoundException
     */
    public function render(): string
    {
        if (!file_exists($this->templatePath)) {
            throw new TemplateNotFoundException;
        }

        extract($this->vars);

        ob_start();
        require $this->templatePath;

        return ob_get_clean();
    }

    /**
     *
     */
    protected function normalizeTemplatePath()
    {
        $this->templatePath = str_replace('//', '/', $this->templatePath);
    }

    /**
     * @param string $templateName
     * @return string
     */
    protected function normalizeTemplateName(string $templateName): string
    {
        if (!Str::endsWith($templateName, '.php')) {
            $templateName .= '.php';
        }

        return $templateName;
    }

    /**
     *
     */
    protected function normalizeOutput(): void
    {
        foreach ($this->vars as &$value) {
            $value = htmlentities($value);
        }
    }
}