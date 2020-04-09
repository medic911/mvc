<?php
$router = app()->getRouter();

$router->addRoute('/example', function(\Medic911\MVC\App $app) {
    return 'This is example route. Request method is ' . request()->getMethod();
});

$router->addRoute('/hello-world', function (\Medic911\MVC\App $app) {
    return new \Medic911\MVC\Core\Http\Response('Hello World!');
});

$router->addRoute('/json', function (\Medic911\MVC\App $app) {
    return [
        'this' => 'is',
        'json' => 'example',
    ];
});

$router->addRoute('/view', function (\Medic911\MVC\App $app) {
    return view('index', [
        'var' => '<script>alert(123);</script>',
    ]);
});