<?php

use App\Exceptions\NotFoundException;
use App\Http\Actions\Action;
use App\Http\Actions\StatusAction;

return function (string $method, string $route): Action {
    return match ("$method $route") {
        'GET /status'   => new StatusAction(),
        //'POST /' => new YourAction(),
        default         => throw new NotFoundException($route),
    };
};
