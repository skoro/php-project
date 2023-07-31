<?php

if (!function_exists('logger')) {
    /**
     * @param array<string, mixed> $context
     */
    function logger(string $message, array $context = []): void
    {
        error_log(sprintf("%s \"%s\"", $message, json_encode($context)));
    }
}

if (!function_exists('report_error')) {
    /**
     * Logs and captures an exception to Sentry.
     *
     * @param Throwable $exception
     * @param array<string, mixed> $context The exception context.
     * @see config.php.dist
     * @const SENTRY_DSN
     */
    function report_error(Throwable $exception, array $context = []): void
    {
        logger($exception->getMessage(), $context);
        if (defined('SENTRY_DSN') && SENTRY_DSN) {
            if ($context) {
                \Sentry\configureScope(function (\Sentry\State\Scope $scope) use ($context) {
                    $scope->setContext('context', $context);
                });
            }
            \Sentry\captureException($exception);
        }
    }
}

if (!function_exists('cpu_cores_count')) {
    /**
     * Gets CPU cores count.
     *
     * Supports Linux & Windows.
     *
     * @return int CPU core count.
     * @throws RuntimeException When cannot get info about CPU.
     */
    function cpu_cores_count(): int
    {
        static $cores = null;
        if ($cores !== null) {
            return $cores;
        }
        if (is_file('/proc/cpuinfo')) {
            $cpuinfo = @file_get_contents('/proc/cpuinfo');
            if ($cpuinfo && preg_match('/^cpu cores[ \t]*:[ \t]*(\d+)$/m', $cpuinfo, $matches)) {
                $cores = (int)$matches[1];
            }
        }
        elseif (PHP_OS_FAMILY === 'Windows') {
            $cores = (int)getenv('NUMBER_OF_PROCESSORS');
        }
        return $cores ?? throw new RuntimeException('Cannot get cpu cores count for your OS: ' . PHP_OS_FAMILY);
    }
}

if (!function_exists('json_response')) {
    function json_response(mixed $data, int $statusCode = 200): \Laminas\Diactoros\Response\JsonResponse
    {
        return new \Laminas\Diactoros\Response\JsonResponse($data, $statusCode);
    }
}
