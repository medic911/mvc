<?
namespace Medic911\MVC\Core\Http;

use Medic911\MVC\Core\Contracts\ResponseContract;

/**
 * Class Response
 * @package Medic911\MVC\Core\Http
 */
class Response implements ResponseContract
{
    /**
     * @var int
     */
    protected int $status;

    /**
     * @var string
     */
    protected string $contentType;

    /**
     * @var array
     */
    protected array $headers = [];

    /**
     * @var string
     */
    protected string $body;

    /**
     * Response constructor.
     * @param string $body
     * @param int $status
     * @param string $contentType
     */
    public function __construct(string $body = '', int $status = 200, string $contentType = 'text/html')
    {
        $this->body = $body;
        $this->status = $status;
        $this->contentType = $contentType;
    }

    /**
     * @param array $data
     * @param int $status
     * @return static
     */
    public static function json(array $data, int $status = 200): self
    {
        return new static(json_encode($data), $status, 'text/plain');
    }

    /**
     * @param string $body
     * @return static
     */
    public static function e404(string $body = '404 Not Found'): self
    {
        return new static($body, 404);
    }

    /**
     * @param string $body
     * @return static
     */
    public static function e500(string $body = 'Something went wrong'): self
    {
        return new static($body, 500);
    }

    /**
     * @param string $body
     * @return $this
     */
    public function withBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $name
     * @param string $value
     * @return $this
     */
    public function withHeader(string $name, string $value): self
    {
        $this->headers[$name] = $value;

        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param int $status
     * @return $this
     */
    public function withStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param string $contentType
     * @return $this
     */
    public function withContentType(string $contentType): self
    {
        $this->contentType = $contentType;

        return $this;
    }

    /**
     * @return string
     */
    public function getContentType(): string
    {
        return $this->contentType;
    }

    /**
     * @codeCoverageIgnore
     */
    public function send(): void
    {
        $this->sendHeaders();
    
        echo $this->body;
    }

    /**
     * @codeCoverageIgnore
     */
    public function sendHeaders(): void
    {
        header("HTTP/1.1: $this->status", );
        header("Content-Type: $this->contentType; charset=UTF-8");
        header('Content-Length: ' . mb_strlen($this->body));

        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }
    }
}