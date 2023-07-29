<?php

declare(strict_types=1);

namespace My\Project\Http\Actions\Concerns;

use JsonException;
use My\Project\Exceptions\BadRequestException;
use Psr\Http\Message\ServerRequestInterface as Request;

use function in_array;
use function json_decode;

use const JSON_THROW_ON_ERROR;

/**
 * Json Request.
 *
 * Provides methods for checking of the content type of the incoming data
 * and decode it.
 */
trait HasJsonRequest
{
    protected function isJson(Request $request): bool
    {
        return in_array('application/json', $request->getHeader('content-type'));
    }

    /**
     * @throws BadRequestException When the request content type is not json.
     * @throws JsonException Json decoding error.
     */
    protected function getJson(Request $request): mixed
    {
        if ($this->isJson($request)) {
            return json_decode($request->getBody()->getContents(), associative: true, flags: JSON_THROW_ON_ERROR);
        }

        throw new BadRequestException('Not a JSON request.');
    }
}
