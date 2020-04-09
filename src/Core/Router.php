<?
namespace Medic911\MVC\Core;

use Medic911\MVC\Core\Contracts\RouterContract;
use Medic911\MVC\Core\Exceptions\NotFoundException;
use Medic911\MVC\Core\Traits\Singleton;
use Closure;

class Router implements RouterContract
{
    /**
     * @var array
     */
    protected array $routes;

    /**
     * @param string $path
     * @param Closure $callback
     */
    public function addRoute(string $path, Closure $callback): void
    {   
        $this->routes[$path] = $callback->bindTo(app(), get_class(app()));
    }

    /**
     * @param string $path
     * @return Closure
     * @throws NotFoundException
     */
    public function match(string $path): Closure
    {
        if (!isset($this->routes[$path])) {
            throw new NotFoundException;
        }

        return $this->routes[$path];
    }
}