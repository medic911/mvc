<?
namespace Medic911\MVC;

use Medic911\MVC\Core\Contracts\RequestContract;
use Medic911\MVC\Core\Contracts\ResponseContract;
use Medic911\MVC\Core\Contracts\RouterContract;
use Medic911\MVC\Core\Contracts\TemplateContract;
use Medic911\MVC\Core\Exceptions\CompileTemplateException;
use Medic911\MVC\Core\Exceptions\InvalidResponseContentException;
use Medic911\MVC\Core\Exceptions\NotFoundRouteException;
use Medic911\MVC\Core\Exceptions\NotFoundTemplateException;
use Medic911\MVC\Core\Http\Response;
use Medic911\MVC\Core\Traits\Singleton;
use Throwable;

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
     * @throws Throwable
     */
    public function handleRequest(RequestContract $request): ResponseContract
    {
        try {
            $callback = $this->router->match($request->getPath());
            $response = $this->tryMakeResponse($callback($this));
        } catch (NotFoundRouteException $e) {
            $this->handleException($e);
            $response = Response::e404();
        } catch (Throwable $e) {
            $this->handleException($e);
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
     * @throws Core\Exceptions\CompileTemplateException
     * @throws InvalidResponseContentException
     * @throws NotFoundTemplateException
     * @throws CompileTemplateException
     */
    protected function tryMakeResponse($result): ResponseContract
    {
        if ($result instanceof ResponseContract) {
            return $result;
        }

        if ($result instanceof TemplateContract) {
            return new Response($result->render());
        }

        if (is_string($result)) {
            return new Response($result);
        }

        if (is_array($result)) {
            return Response::json($result);
        }

        throw new InvalidResponseContentException;
    }

    /**
     * @param Throwable $e
     * @throws Throwable
     */
    protected function handleException(Throwable $e): void
    {
        if (!inProduction()) {
            throw $e;
        }
    }
}