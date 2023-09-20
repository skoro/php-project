## Project skeleton
A project skeleton in pure php. This skeleton can be used to prototype
some simple services where the usage of a framework is over bloated.

## Getting started
There is two choices of running the application:
1. php-fpm
2. swoole

All those build by default as `app` and `app-server` containers.

```shell
docker-compose up -d
```

## Routes
Routes are defined in `./src/Http/routes.php` file. The callback accepts the request method and the uri.
Only static routes are allowed, if you need some dynamic, please use query arguments.

The `/status` route is predefined and returns a response with some system info.

## Logging
There are two available functions for logging:
- `logger(string $message, array $context)` which rely on [error_log](https://www.php.net/manual/en/function.error-log.php)
    function.
- `report_error(\Throwable $e, array $context)` as `logger` but also sends an exception to [Sentry](https://sentry.io)
    when `SENTRY_DSN` constant is defined.

## Documentation
[swagger-php](http://zircote.github.io/swagger-php/) is used for generating documentation
in OpenAPI format:
```shell
composer make-api
```


## Tests
```shell
composer test
composer check
```

## Missing features:
- DI
- Advanced routing
- Database
