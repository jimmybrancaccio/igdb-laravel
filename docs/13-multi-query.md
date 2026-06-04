# Multi-query

IGDB supports sending up to 10 named queries in a single request to the `multiquery` endpoint.

```php
// torchlight! {"lineNumbers": false}
use MarcReichel\IGDBLaravel\Builder as IGDB;

$results = IGDB::multiQuery([
    'recent-games' => (new IGDB('games'))->select('name')->limit(10),
    'platforms' => (new IGDB('platforms'))->select('name')->limit(10),
]);
```

You can also pass a raw Apicalypse string when you need full control over one query body.

```php
// torchlight! {"lineNumbers": false}
use MarcReichel\IGDBLaravel\Builder as IGDB;

$results = IGDB::multiQuery([
    'games' => 'fields name; limit 10;',
]);
```
