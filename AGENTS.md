# Repository Guidelines

## Project Shape

- This is a PHP package for Laravel, not a full Laravel app. Package code lives in `src/`, tests live in `tests/`, docs live in `docs/`, and publishable config lives in `config/config.php`.
- The package targets PHP `^8.4` and Laravel `^12.0|^13.0` through `illuminate/support`; keep compatibility changes grounded in `composer.json` and the GitHub Actions matrices.
- Do not edit generated or cache output such as `.phpunit.cache/` or `build/`.

## Common Commands

- Install dependencies with `composer install`.
- Run the default test suite with `composer test` (`./vendor/bin/pest --parallel --no-coverage`).
- Check formatting with `composer pint` (`./vendor/bin/pint --test -v`).
- Run static analysis with `composer stan` (`./vendor/bin/phpstan --memory-limit=2G`).
- PHPStan may need unsandboxed execution locally because it opens a local TCP worker socket.
- Check coverage with `composer test:coverage`; it requires Xdebug and enforces `--min=90`.
- Check type coverage with `composer test:type-coverage`; it requires Xdebug and enforces `--min=100`.
- If Xdebug is not loaded in the active PHP runtime, skip the coverage and type-coverage commands locally rather than treating that as a package failure.

## Testing Notes

- Tests use Pest with Orchestra Testbench; shared helpers and package setup are in `tests/TestCase.php`.
- The default PHPUnit config sets `IGDB_WEBHOOK_SECRET=secret` and uses random test execution order with warnings, risky tests, and output during tests treated as failures.
- HTTP/API behavior is generally tested with Laravel HTTP fakes and helpers such as `isApiCall()`, `isWebhookCall()`, and `createWebhookResponse()`.
- IGDB endpoint coverage is guarded by `tests/Fixtures/igdb-endpoints.php`; update that fixture when intentionally syncing the package against the live IGDB docs.
- Some models need a `public const string ENDPOINT` override when Laravel pluralization does not match IGDB paths, such as `Search` or `AgeRatingContentDescriptionV2`.
- Not every queryable IGDB model has webhook support. Use `modelsDataProvider()` for general model coverage and `webhookModelsDataProvider()` for webhook/event/category assertions.

## CI Workflows

- Pull requests to `main` run tests across PHP 8.4/8.5 and Laravel 12/13, Pint on PHP 8.5, PHPStan on PHP 8.5, and type coverage on PHP 8.5.
- The Codecov workflow currently runs only on pushes to `main` and uses older Laravel/PHP matrix entries; TODO: verify whether that legacy matrix is still intentional before changing it.
- Docs deploy only on pushes to `main` that touch `docs/**/*` or via manual `workflow_dispatch`.
