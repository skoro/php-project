<?php

declare(strict_types=1);

namespace Tests;

use App\Exceptions\NotFoundException;

class RoutesTest extends TestCase
{
    public function test_route_not_found_exception(): void
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionCode(404);

        $this->router('METHOD', '/route/not/found');
    }
}
