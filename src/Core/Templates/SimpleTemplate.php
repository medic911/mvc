<?

namespace Medic911\MVC\Core\Templates;

use Illuminate\Support\Str;
use Medic911\MVC\Core\Contracts\TemplateContract;
use Medic911\MVC\Core\Exceptions\CompileTemplateException;
use Medic911\MVC\Core\Exceptions\NotFoundTemplateException;

/**
 * Class SimpleTemplate
 * @package Medic911\MVC\Core\Templates
 */
class SimpleTemplate extends AbstractTemplate implements TemplateContract
{
    /**
     * @var string
     */
    protected string $templatePath;

    /**
     * @return string
     * @throws CompileTemplateException
     * @throws NotFoundTemplateException
     */
    public function render(): string
    {
        if (!file_exists($this->templatePath)) {
            throw new NotFoundTemplateException;
        }

        extract($this->context);

        try {
            ob_start();
            require $this->templatePath;
        } catch (\Throwable $e) {
            throw new CompileTemplateException($e->getMessage(), $e->getCode(), $e);
        }

        return ob_get_clean();
    }

    /**
     *
     */
    protected function initialize(): void
    {
        $this->normalizeTemplateName();

        $this->templatePath = $this->basePath . '/' . $this->templateName;

        $this->normalizeTemplatePath();
        $this->normalizeContext();
    }

    /**
     *
     */
    protected function normalizeTemplatePath()
    {
        $this->templatePath = str_replace('//', '/', $this->templatePath);
    }

    /**
     *
     */
    protected function normalizeTemplateName(): void
    {
        if (!Str::endsWith($this->templateName, '.php')) {
            $this->templateName .= '.php';
        }
    }

    /**
     *
     */
    protected function normalizeContext(): void
    {
        foreach ($this->context as &$value) {
            $value = htmlentities($value);
        }
    }
}