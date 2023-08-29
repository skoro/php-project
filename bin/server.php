<?php

define('ROOT_DIR', dirname(__DIR__));

if (!extension_loaded('swoole')) {
    die("Error: for standalone server 'swoole' extension is required.\n");
}

require_once ROOT_DIR . '/vendor/autoload.php';

$server = new \Swoole\Http\Server('0.0.0.0', 9501, SWOOLE_BASE);
$server->set([
    //'worker_num' => swoole_cpu_num(),
]);

$actionCallback = require_once ROOT_DIR . '/src/Http/routes.php';
$streamFactory = new \Laminas\Diactoros\StreamFactory();

$server->on('start', function () {
    //
});

$server->on('request', function (\Swoole\Http\Request $request, \Swoole\Http\Response $response) use ($actionCallback, $streamFactory) {
    $server = array_change_key_case($request->server, CASE_UPPER);

    foreach ($request->header as $name => $value) {
        $server["HTTP_$name"] = $value;
    }

    $method = $request->server['request_method'];

    try {
        $psrRequest = \Laminas\Diactoros\ServerRequestFactory::fromGlobals(
            server: $server,
            query: $request->get,
            body: $request->post,
            cookies: $request->cookie,
            files: $request->files,
        );

        /** @var \App\Http\Actions\Action $action */
        $action = $actionCallback($method, $request->server['request_uri']);

        if ($method !== 'GET') {
            $psrRequest = $psrRequest->withBody($streamFactory->createStream($request->rawContent()));
        }

        $psrResponse = $action($psrRequest);

        $response->status($psrResponse->getStatusCode());

        foreach ($psrResponse->getHeaders() as $name => $values) {
            $response->header($name, $values);
        }

        $stream = $psrResponse->getBody();

        if ($stream->isSeekable()) {
                $stream->rewind();
        }

        $response->end($stream->getContents());

    } catch (Throwable $e) {
        $response->status($e->getCode());
        report_error($e);
    }
});

$server->start();
