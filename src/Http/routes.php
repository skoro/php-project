<?php

use My\Project\Exceptions\NotFoundException;
use My\Project\Http\Actions\Action;
use My\Project\Http\Actions\StatusAction;

return function (string $method, string $route): Action {
    return match ("$method $route") {
        'GET /status'   => new StatusAction(),
        //'POST /' => new YourAction(),
        default         => throw new NotFoundException($route),
    };
};
