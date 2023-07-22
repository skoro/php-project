<?php

declare(strict_types=1);

namespace My\Project\Http\Actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

interface Action
{
    public function __invoke(Request $request): Response;
}
