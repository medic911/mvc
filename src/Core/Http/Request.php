<?
namespace Medic911\MVC\Core\Http;

use Medic911\MVC\Core\Contracts\RequestContract;
use Medic911\MVC\Core\Traits\Singleton;

/**
 * Class Request
 * @package Medic911\MVC\Core\Http
 */
class  Request implements RequestContract
{
    use Singleton;

    /**
     * @var string
     */
    protected string $path;

    /**
     * @var string
     */
    protected string $method;

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     *
     */
    protected function initialize(): void
    {
        $this->path = (string) parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->method = $_SERVER['REQUEST_METHOD'];
    }
}