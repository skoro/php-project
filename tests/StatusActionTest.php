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

    public function test_status_action_json_status(): void
    {
        $json = $this->getStatusActionJsonResponse();
        $this->assertEquals('ok', $json['status']);
    }

    public function test_status_action_json_structure_php(): void
    {
        $json = $this->getStatusActionJsonResponse();
        $this->assertArrayHasKey('php', $json);
        $this->assertNotEmpty($json['php']['ver']);
        $this->assertArrayHasKey('time', $json['php']); // START_TIME is null on tests.
        $this->assertNotEmpty($json['php']['memory']);
    }

    public function test_status_action_json_structure_disk(): void
    {
        $json = $this->getStatusActionJsonResponse();
        $this->assertArrayHasKey('disk', $json);
        $this->assertNotEmpty($json['disk']['total']);
        $this->assertNotEmpty($json['disk']['free']);
        $this->assertNotEmpty($json['disk']['used']);
        $this->assertNotEmpty($json['disk']['used_%']);
        $this->assertIsInt($json['disk']['used_%']);
    }

    /**
     * this test depends on /proc/loadavg file and can be failed on non linux systems.
     */
    public function test_status_action_json_structure_cpu(): void
    {
        $json = $this->getStatusActionJsonResponse();
        $this->assertArrayHasKey('sysload', $json);
        $this->assertCount(3, $json['sysload']);
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
