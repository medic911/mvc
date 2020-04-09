<?
namespace Medic911\MVC\Core;

use Medic911\MVC\Core\Contracts\RouterContract;
use Medic911\MVC\Core\Exceptions\NotFoundRouteException;
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
     * @throws NotFoundRouteException
     */
    public function match(string $path): Closure
    {
        if (!isset($this->routes[$path])) {
            throw new NotFoundRouteException;
        }

        return $this->routes[$path];
    }
}