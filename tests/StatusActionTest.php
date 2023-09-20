<?php

declare(strict_types=1);

namespace Tests;

use Laminas\Diactoros\Response\JsonResponse;
use App\Http\Actions\StatusAction;
use Psr\Http\Message\ServerRequestInterface;

class StatusActionTest extends TestCase
{
    public function test_status_action_is_routable(): void
    {
        $action = $this->router('GET', '/status');

        $this->assertInstanceOf(StatusAction::class, $action);
    }

    public function test_status_action_returns_json_response(): void
    {
        $action = new StatusAction();

        $request = $this->createStub(ServerRequestInterface::class);
        $response = $action($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
    }

    public function test_status_action_returns_200_status_code(): void
    {
        $action = new StatusAction();

        $request = $this->createStub(ServerRequestInterface::class);
        $response = $action($request);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_status_action_json_structure_php(): void
    {
        $json = $this->getStatusActionJsonResponse();
        $this->assertArrayHasKey('php_version', $json);
    }

    public function test_status_action_json_structure_memory_usage(): void
    {
        $json = $this->getStatusActionJsonResponse();
        $this->assertArrayHasKey('memory_usage', $json);
    }

    public function test_status_action_json_bench_time(): void
    {
        $json = $this->getStatusActionJsonResponse();
        $this->assertArrayHasKey('bench_time', $json);
    }

    public function test_status_action_json_structure_sys_load(): void
    {
        $json = $this->getStatusActionJsonResponse();
        $this->assertArrayHasKey('sys_avg_load', $json);
        $this->assertCount(3, $json['sys_avg_load']);
    }

    /**
     * @return array<string, mixed>
     */
    private function getStatusActionJsonResponse(): array
    {
        $action = new StatusAction();

        $request = $this->createStub(ServerRequestInterface::class);
        $dump = $action($request)->getBody()->getContents();

        return json_decode($dump, associative: true, flags: JSON_THROW_ON_ERROR);
    }
}
