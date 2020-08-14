<?

namespace Medic911\MVC\Core\Templates;

/**
 * Class AbstractTemplate
 * @package Medic911\MVC\Core\Templates
 */
abstract class AbstractTemplate
{
    /**
     * @var string
     */
    protected string $templateName;

    /**
     * @var array
     */
    protected array $context;

    /**
     * @var string
     */
    protected string $basePath = BASE_DIR . '/src/Templates';

    /**
     * AbstractTemplate constructor.
     * @param string $templateName
     * @param array $context
     */
    public function __construct(string $templateName, array $context)
    {
        $this->templateName = $templateName;
        $this->context = $context;

        $this->initialize();
    }

    /**
     *
     */
    protected abstract function initialize(): void;
}