<?

namespace Medic911\MVC\Core\Templates;

use Illuminate\Support\Str;
use Medic911\MVC\Core\Contracts\TemplateContract;
use Medic911\MVC\Core\Exceptions\CompileTemplateException;
use Medic911\MVC\Core\Exceptions\NotFoundTemplateException;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

/**
 * Class TwigTemplate
 * @package Medic911\MVC\Core\Templates
 */
class TwigTemplate extends AbstractTemplate implements TemplateContract
{
    /**
     * @var Environment
     */
    protected Environment $twig;

    /**
     * @return string
     * @throws CompileTemplateException
     * @throws NotFoundTemplateException
     */
    public function render(): string
    {
        try {
            $content = $this->twig->render($this->templateName, $this->context);
        } catch (LoaderError $e) {
            throw new NotFoundTemplateException($e->getMessage(), $e->getCode(), $e);
        } catch (RuntimeError|SyntaxError $e) {
            throw new CompileTemplateException($e->getMessage(), $e->getCode(), $e);
        }

        return $content;
    }

    /**
     *
     */
    protected function initialize(): void
    {
        $loader = new FilesystemLoader($this->basePath);
        $this->twig = new Environment($loader, [
            'debug' => !inProduction(),
            'cache' => $this->basePath . '/cache',
        ]);

        $this->normalizeTemplateName();
    }

    /**
     *
     */
    protected function normalizeTemplateName(): void
    {
        if (!Str::endsWith($this->templateName, '.html.twig')) {
            $this->templateName .= '.html.twig';
        }
    }
}