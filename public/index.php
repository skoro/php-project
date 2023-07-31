<?php

use Laminas\Diactoros\ServerRequestFactory;

define('START_TIME', hrtime(as_number: true));
define('ROOT_DIR', dirname(__DIR__));

require_once ROOT_DIR . '/vendor/autoload.php';

try {
    $uri    = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
    $method = $_SERVER['REQUEST_METHOD'] ?? '';

    /** @var \App\Http\Actions\Action $action */
    $action = (require_once ROOT_DIR . '/src/Http/routes.php')($method, $uri);

    /** @var \Psr\Http\Message\ResponseInterface $response */
    $response = $action(ServerRequestFactory::fromGlobals());

    http_response_code($response->getStatusCode());

    foreach ($response->getHeaders() as $name => $values) {
        foreach ($values as $value) {
            header("$name: $value", replace: false);
        }
    }

    echo $response->getBody()->getContents();

} catch (Throwable $e) {
    http_response_code($e->getCode());
    report_error($e);
}
