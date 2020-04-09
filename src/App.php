<?
namespace Medic911\MVC;

use Medic911\MVC\Core\Contracts\RequestContract;
use Medic911\MVC\Core\Contracts\ResponseContract;
use Medic911\MVC\Core\Contracts\RouterContract;
use Medic911\MVC\Core\Exceptions\InvalidResponseException;
use Medic911\MVC\Core\Exceptions\NotFoundException;
use Medic911\MVC\Core\Http\Response;
use Medic911\MVC\Core\Traits\Singleton;

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
        } catch (NotFoundException $e) {
            $response = Response::e404();
        } catch (InvalidResponseException $e) {
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
     * @return Response
     * @throws InvalidResponseException
     */
    protected function tryMakeResponse($result): ResponseContract
    {
        if ($result instanceof Response) {
            return $result;
        }

        if (is_string($result)) {
            return new Response($result);
        }

        if (is_array($result)) {
            return Response::json($result);
        }

        throw new InvalidResponseException();
    }
}