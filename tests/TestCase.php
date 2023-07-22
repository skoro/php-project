<?php

declare(strict_types=1);

namespace Tests;

use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\StreamFactory;
use My\Project\Http\Actions\Action;
use Psr\Http\Message\ServerRequestInterface;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected const ROUTE_FILE = __DIR__ . '/../src/Http/routes.php';

    protected function setUp(): void
    {
        parent::setUp();

        if (!defined('ROOT_DIR')) {
            define('ROOT_DIR', dirname(__DIR__));
        }
    }

    protected function router(string $method, string $route): Action
    {
        return (require self::ROUTE_FILE)($method, $route);
    }

    protected function makeJsonRequest(mixed $json): ServerRequestInterface
    {
        $body = (new StreamFactory())->createStream(json_encode($json));
        return new ServerRequest(
            method: 'POST',
            body: $body,
            headers: [
                'content-type' => 'application/json',
            ],
        );
    }
}
