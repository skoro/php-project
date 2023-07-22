<?php

declare(strict_types=1);

namespace My\Project\Http\Actions;

use JsonException;
use My\Project\Exceptions\BadRequestException;
use Psr\Http\Message\ServerRequestInterface as Request;

use const JSON_THROW_ON_ERROR;

use function in_array;
use function json_decode;

/**
 * Json Action.
 *
 * Provides a method for checking of the content type of incoming data
 * and decode it.
 */
abstract class JsonAction implements Action
{
    /**
     * @throws BadRequestException When the request content type is not json.
     * @throws JsonException Json decoding error.
     */
    protected function getJson(Request $request): mixed
    {
        if (!in_array('application/json', $request->getHeader('content-type'))) {
            throw new BadRequestException('Not a JSON request.');
        }

        return json_decode($request->getBody()->getContents(), associative: true, flags: JSON_THROW_ON_ERROR);
    }
}
