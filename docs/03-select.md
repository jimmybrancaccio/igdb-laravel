# Select (Fields)

Select which fields should be in the response. If you want to have all available fields in the response you can also
skip this method as the query builder will select `*` by default. (**Attention**: This is the opposite behaviour from
the Apicalypse API)

```php
// torchlight! {"lineNumbers": false}
use MarcReichel\IGDBLaravel\Models\Game;

$games = Game::select(['*'])->get();

$games = Game::select(['name', 'first_release_date'])->get();
```

## Exclude fields

The IGDB API also supports `exclude` clauses. This is useful when selecting all fields but skipping large or irrelevant
properties.

```php
// torchlight! {"lineNumbers": false}
use MarcReichel\IGDBLaravel\Models\Platform;

$platforms = Platform::select(['*'])
    ->exclude('alternative_name')
    ->get();
```
