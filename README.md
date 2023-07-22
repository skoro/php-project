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

## Documentation
Use `./public/openapi.yml` to document your API.

## Tests
```shell
composer test
composer check
```
