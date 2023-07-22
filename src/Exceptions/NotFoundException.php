<?php

declare(strict_types=1);

namespace My\Project\Exceptions;

/**
 * @link https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/404
 */
final class NotFoundException extends Exception
{
    public function __construct(public readonly string $route)
    {
        parent::__construct('Not Found', 404);
    }
}
