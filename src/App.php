<?
namespace Medic911\MVC;

use Medic911\MVC\Core\Contracts\RequestContract;
use Medic911\MVC\Core\Contracts\ResponseContract;
use Medic911\MVC\Core\Contracts\RouterContract;
use Medic911\MVC\Core\Contracts\ViewContract;
use Medic911\MVC\Core\Exceptions\InvalidRouteResultException;
use Medic911\MVC\Core\Exceptions\NotFoundRouteException;
use Medic911\MVC\Core\Exceptions\NotFoundTemplateException;
use Medic911\MVC\Core\Http\Response;
use Medic911\MVC\Core\Traits\Singleton;
use function PHPUnit\Framework\assertDirectoryDoesNotExist;

/**
 * Class App
 * @package Medic911\MVC
 */
class App
{
    use Singleton;

    /**
     * @var RouterContract
     */
    protected RouterContract $router;

    /**
     * @param RequestContract $request
     * @return ResponseContract
     */
    public function handleRequest(RequestContract $request): ResponseContract
    {
        try {
            $callback = $this->router->match($request->getPath());
            $response = $this->tryMakeResponse($callback($this));
        } catch (NotFoundRouteException $e) {
            $response = Response::e404();
        } catch (InvalidRouteResultException | NotFoundTemplateException $e) {
            $response = Response::e500();
        }

        return $response;
    }

    /**
     * @param RouterContract $router
     */
    public function setRouter(RouterContract $router): void
    {
        $this->router = $router;
    }

    /**
     * @return RouterContract
     */
    public function getRouter(): RouterContract
    {
        return $this->router;
    }

    /**
     * @param $result
     * @return ResponseContract
     * @throws InvalidRouteResultException
     * @throws NotFoundTemplateException
     */
    protected function tryMakeResponse($result): ResponseContract
    {
        if ($result instanceof ResponseContract) {
            return $result;
        }

        if ($result instanceof ViewContract) {
            return new Response($result->render());
        }

        if (is_string($result)) {
            return new Response($result);
        }

        if (is_array($result)) {
            return Response::json($result);
        }

        throw new InvalidRouteResultException;
    }
}