## Project skeleton
A project skeleton in pure php. This skeleton can be used to prototype
some simple services where the usage of a framework is over bloated.

## Getting started
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
Use `./public/openapi.yml` to document your API.

## Missing features:
- DI
- Advanced routing

## Tests
```shell
composer test
composer check
```
