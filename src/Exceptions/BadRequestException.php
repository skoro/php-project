<?php

declare(strict_types=1);

namespace App\Exceptions;

/**
 * @link https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/400
 */
final class BadRequestException extends Exception
{
    /** @var int */
    protected $code = 400;
}
