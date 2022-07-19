Backend RPC Api
============
 Backend RPC service. Part of the microservice core that contains business logic.

## Implementations

- [x] Environment in Docker
- [x] Command Bus, Event Bus
- [x] Event Store
- [x] Read Model
- [x] Async Event subscribers

## Stack

- PHP 8.1
- PostgreSQL
- Kafka

## Requests

Get api documentation in JSON format.

`curl 'http://localhost:9501/doc'`

Get api documentation in OpenApi3 format.

`curl 'http://localhost:9501/doc/openapi.json'`

Get documentation in beauty Swagger format (open in browser).

`http://localhost:9501/docs`

Curl rpc 'ping' request.

`curl 'http://localhost:9501/json-rpc' --data-binary '[{ "jsonrpc":"2.0","method":"ping","params":[],"id" : 1 }]'`

Curl rpc 'add' item request.

`curl 'http://localhost:9501/json-rpc' --data-binary '[{ "jsonrpc":"2.0","method":"add","params":{"version": "0.0.1", "parentId": 2, "name": "test2", "url": "http://test2.com", "status": 1}, "id" : 2 }]'`

Curl rpc 'find' item  request.

`curl 'http://localhost:9501/json-rpc' --data-binary '[{ "jsonrpc":"2.0","method":"find","params":{"parent_id" : 2},"id" : 1}]'`

Curl rpc 'fetch' item  request.

`curl 'http://localhost:9501/json-rpc' --data-binary '[{ "jsonrpc":"2.0","method":"fetch","params":{"uuid": "2d291dbd-40b0-484e-9e94-40a015d99a63"},"id" : 1}]'`

Curl rpc 'update' item  request.

`curl 'http://localhost:9501/json-rpc' --data-binary '[{ "jsonrpc":"2.0","method":"update", "params":{"version": "0.0.1","uuid": "2d291dbd-40b0-484e-9e94-40a015d99a63", "parentId": 3,"name": "test3","url": "http://test3.com","status": 1},"id" : 1}]'`

Curl rpc 'delete' item  request.

`curl 'http://localhost:9501/json-rpc' --data-binary '[{ "jsonrpc":"2.0","method":"delete","params":{"version": "0.0.1", "uuid": "2d291dbd-40b0-484e-9e94-40a015d99a63"},"id" : 1 }]'`

## Project Setup

Up new environment:

`make install`

See all make commands

`make help`

Full test circle

`make test`

Execute tests:

`tests-unit`
`tests-integration`

Static code analysis:

`make style`

Code style fixer:

`make coding-standards-fixer`

Code style checker (PHP CS Fixer and PHP_CodeSniffer):

`make coding-standards`

Psalm is a static analysis tool for finding errors in PHP applications, built on top of PHP Parser:

`make psalm`

PHPStan focuses on finding errors in your code without actually running it.

`make phpstan`

Phan is a static analyzer for PHP that prefers to minimize false-positives. Phan attempts to prove incorrectness rather than correctness.

`make phan`

Deptrac is a static code analysis tool that helps to enforce rules for dependencies between software layers in your PHP projects.

`make layer`

Security Checker is a command line tool that checks if your application uses dependencies with known security vulnerabilities. It uses the Security Check Web service and the Security Advisories Database.

`security-tests`

Enter in php container:

`make php-shell`

Watch containers logs

`make logs`
