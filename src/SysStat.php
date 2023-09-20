<?php

declare(strict_types=1);

namespace App;

use OpenApi\Attributes as OA;

#[OA\Schema(
    title: 'System status',
    description: 'Provides system status details.',
    properties: [
        new OA\Property(
            property: 'php_version',
            description: 'PHP Version',
            type: 'string',
            example: '8.2.1',
        ),
        new OA\Property(
            property: 'memory_usage',
            description: 'Formatted string of the request used memory (in kilobytes)',
            type: 'string',
            example: '361,904',
        ),
        new OA\Property(
            property: 'bench_time',
            description: 'Request execution time in seconds',
            type: 'number',
            example: 0.308683,
        ),
        new OA\Property(
            property: 'sys_avg_load',
            description: 'Average load for 1, 5 and 15 minutes',
            type: 'array',
            items: new OA\Items(type: 'number'),
            maxItems: 3,
            minItems: 3,
        ),
    ]
)]
final class SysStat implements \JsonSerializable
{
    /**
     * @return array{php_version: string, memory_usage: int, bench_time: float|null, sys_avg_load: array<int>}
     */
    public function jsonSerialize(): array
    {
        return [
            'php_version'  => $this->phpVersion(),
            'memory_usage' => $this->memoryUsage(),
            'bench_time'   => $this->benchTime(),
            'sys_avg_load' => \sys_getloadavg() ?: [],
        ];
    }

    public function phpVersion(): string
    {
        return \sprintf('%d.%d.%d', \PHP_MAJOR_VERSION, \PHP_MINOR_VERSION, \PHP_RELEASE_VERSION);
    }

    public function memoryUsage(): int
    {
        return \memory_get_peak_usage();
    }

    public function benchTime(): float|null
    {
        return \defined('START_TIME') ? (\hrtime(true) - START_TIME)/1e+6 : null;
    }
}
