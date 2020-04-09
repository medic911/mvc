<?

define('APP_START', microtime(true));

require __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/src/bootstrap.php';

require_once __DIR__ . '/src/routes.php';

app()->handleRequest(request())
     ->send();
