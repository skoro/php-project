#!/usr/bin/env bash

set -e

composer install

# first arg is `-f` or `--some-option`
# if [ "${1#-}" != "$1" ]; then
#         set -- php-fpm "$@"
# fi

exec "$@"
