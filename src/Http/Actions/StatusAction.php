<?php

declare(strict_types=1);

namespace App\Http\Actions;

use App\SysStat;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use OpenApi\Attributes as OA;

#[OA\Get(path: '/status', summary: 'Get the service status')]
#[OA\Response(
    response: '200',
    description: 'The service health status',
    content: new OA\JsonContent(ref: '#/components/schemas/SysStat')
)]
class StatusAction implements Action
{
    public function __invoke(Request $request): Response
    {
        return json_response(new SysStat());
    }
}
