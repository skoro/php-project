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

